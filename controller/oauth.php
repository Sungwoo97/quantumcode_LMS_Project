<?php 
	try{
		// ![수정필요] 카카오 API 환경설정 파일 
		include_once "config.php";
        include_once("..\DB\db_connection.php"); // DB 연결

		// 기본 응답 설정
		$res = array('rst'=>'fail','code'=>(__LINE__*-1),'msg'=>'');

		// code && state 체크
		if( empty($_GET['code']) || empty($_GET['state']) ||  $_GET['state'] != $_COOKIE['state']){ throw new Exception("인증실패", (__LINE__*-1) );}
			

		// 토큰 요청
		$replace = array(
			'{grant_type}'=>'authorization_code',
			'{client_id}'=>$kakaoConfig['client_id'],
			'{redirect_uri}'=>$kakaoConfig['redirect_uri'],
			'{client_secret}'=>$kakaoConfig['client_secret'],
			'{code}'=>$_GET['code']
		);
		$login_token_url = str_replace(array_keys($replace), array_values($replace), $kakaoConfig['login_token_url']);
		$token_data = json_decode(curl_kakao($login_token_url));
		if( empty($token_data)){ throw new Exception("토큰요청 실패", (__LINE__*-1) ); }
		if( !empty($token_data->error) || empty($token_data->access_token) ){ 
			throw new Exception("토큰인증 에러", (__LINE__*-1) ); 
		}


		// 프로필 요청 
		$header = array("Authorization: Bearer ".$token_data->access_token);
		$profile_url = $kakaoConfig['profile_url'];
		$profile_data = json_decode(curl_kakao($profile_url,$header));
		if( empty($profile_data) || empty($profile_data->id) ){ throw new Exception("프로필요청 실패", (__LINE__*-1) ); }

        

		// 프로필정보 저장 -- DB를 통해 저장하세요
		/*
			echo '<pre>';
			print_r($profile_data);
			echo '</pre>';		
			exit;
		*/
    
        try{
            
        // CANNOT USE OBJECT OF TYPE STDCLASS AS ARRAY 해결법
        $xml_data=json_encode($profile_data);
        $xml_data=json_decode($xml_data,true);
        // json 타입으로 변경해준다.

        $json_profile_data_array = array_merge($xml_data['properties'],$xml_data['kakao_account']); // 배열 합치기 이게 최종 배열
        // $json_profile_data_unique_array = array_unique($json_profile_data_array); // 종복된 배열의 값 삭제
        foreach ($json_profile_data_array as $key => $val){    // 세션에 profile_date 값을 다 넣어준다.
            if(!is_numeric($key)){  // key 값이 정수 일때가 아닐경우 넣어준다.
                $_SESSION[$key] = $val;
                // Session 의 키 값이 숫자 들어갈 경우 오류가 발생하므로
                // key값에 숫자를 넣지 않는다.
            }
        }  // foreach

        // DB 내 같은 이메일이 있는지 확인. 나중엔 핸드폰 번호로 확인하면 된다. 
        
        $sql_query = "select * from member_table where memEmail = '".$json_profile_data_array["email"]."' "; //DB 쿼리문 작성
        $result = mysqli_query($connect, $sql_query);   //쿼리문으로 받은 데이터를 $result에 넣어준다.
        $memInfo = mysqli_fetch_array($result);   // 이메일이 같은게 있다면 모든 정보를 가져온다.
        
        
		//$is_member = true; // 기존회원인지(true) / 비회원인지(false) db 체크 
		// 로그인 회원일 경우
		if(isset($memInfo)){
            $_SESSION[ 'yes' ] = 11111111;
		} // if
		// 새로 가입일 경우
		else{
            $sql_query = "Insert into member_table (memName,memPassword,memEmail,memId,memProfilePath,memProfileName,memAddr) ".
            "values ('".$json_profile_data_array["nickname"]."','kakaoPassword','".$json_profile_data_array["email"]."','kakaoId','','".$json_profile_data_array["profile_image"]."','kakaoAddr')";
            mysqli_query($connect, $sql_query);   //쿼리문으로 받은 데이터를 $result에 넣어준다.
            
            $_SESSION[ 'no' ] = 00000000;
        } // else
        }

        catch(Exception $e){

        }
        
        // try{
        //     // CANNOT USE OBJECT OF TYPE STDCLASS AS ARRAY 해결법
        // $xml_data=json_encode($profile_data);
        // $xml_data=json_decode($xml_data,true);


                    
           
		// }
        // }        
        
		
		// 최종 성공 처리
		$res['rst'] = 'success';

	}catch(Exception $e){
		if(!empty($e->getMessage())){ $res['msg'] = $e->getMessage(); }
		if(!empty($e->getMessage())){ $res['code'] = $e->getCode(); }
	}


	// 성공처리
	if($res['rst'] == 'success'){

	}

	// 실패처리 
	else{
        
	}
    // 데이터입력 후 데이터베이스 연결을 무조건 끊어줘야함
    mysqli_close($connect); 
	// state 초기화 
	setcookie('state','',time()-3000); // 300 초동안 유효

	header("Location: ../test.php");
    // index 페이지 이동
	exit;