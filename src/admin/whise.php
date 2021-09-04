<?php

function wf_fetch_estates(){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.whise.eu/v1/estates/list',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.get_option('whise_token')
        ),
    ));

    try{
        $response = curl_exec($curl);
    }catch(Exception $e){
        curl_close($curl);
        return false;
    }
    

    curl_close($curl);
    return json_decode($response, true);
}

function wf_serialize_data($value){
    return maybe_serialize($value);
}

function wf_create_post(){
    if( $estates = wf_fetch_estates() ){
        foreach($estates['estates'] as $estate){
            $estate_post = array(
                'post_type'     => 'estates',
                'import_id'     => $estate['id'],
                'post_title'    => $estate['name'],
                'post_status'   => 'publish',
                'meta_input'    => array_map('wf_serialize_data', $estate)
            );

            if( get_post( $estate['id'] ) ){
                $estate_post['ID'] = $estate['id'];
            }else {
                $estate_post['import_id'] = $estate['id'];
            }
            

            if( !wp_insert_post( $estate_post ) ){
                throw new Exception('Synchronization problem');
            }
        }
    }else{
        throw new Exception('Fail to fetch');
    }
}