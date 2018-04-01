<?php
if (!defined('KS')) {
    die('Tidak boleh diakses langsung.');
}

function prosesApiMessage($sumber)
{
    $updateid = $sumber['update_id'];
    if (isset($sumber['message'])) {
        $message = $sumber['message'];
        if (isset($message['text'])) {
			//memproses balasan pesan
            prosesPesanTeks($message);
        } elseif (isset($message['sticker'])) {
            //proses jika pesan adalah sticker
			prosesPesanSticker($message);
        } 
        else {
            // tidak di proses silakan dikembangkan sendiri
        }
    }
    if (isset($sumber['callback_query'])) {
        prosesCallBackQuery($sumber['callback_query']);
    }
    return $updateid;
}
function prosesPesanSticker($message)
{
    // if ($GLOBALS['debug']) mypre($message);
}
function prosesCallBackQuery($message)
{
    $message_id = $message['message']['message_id'];
    $chatid = $message['message']['chat']['id'];
    $data = $message['data'];
    editMessageText($chatid, $message_id, '*pesan sedang aku proses.. 👀 *');
    $messageupdate = $message['message'];
    $messageupdate['text'] = $data;
    deleteMsg($chatid, $message_id);
    prosesPesanTeks($messageupdate);
    //editMessageText($chatid, $message_id, '*✔️ Selesai!*');    
}

function prosesPesanTeks($message)
{
    $msgid = $message['message_id'];
    $pesan = $message['text'];
    $chatid = $message['chat']['id'];
    $chattype = $message['chat']['type'];
    $fromid = $message['from']['id'];    
    if(isset($message['from']['username'])){
        $username = $message['from']['username'];
    }
    if(isset($message['reply_to_message']['from']['id'])){
        $rplid = $message['reply_to_message']['from']['id'];
    }
    else{
        $rplid = "";
    }
    if(isset($message['reply_to_message']['from']['username'])){
        $rplusername = $message['reply_to_message']['from']['username'];
    }
    else{
        $rplusername = "";
    }
    if(isset($message['reply_to_message']['from']['first_name'])){
        $rplfname = $message['reply_to_message']['from']['first_name'];
    }
    else{
        $rplfname = "";
    }
    if(isset($message['reply_to_message']['from']['last_name'])){
        $rpllname = $message['reply_to_message']['from']['last_name'];
    }
    else{
        $rpllname = "";
    }
    if(isset($message['reply_to_message']['text'])){
        $rpltext = $message['reply_to_message']['text'];
    }
    else{
        $rpltext = "";
    }
    if(isset($message['reply_to_message']['message_id'])){
        $rplmsgid = $message['reply_to_message']['message_id'];
    }
    else{
        $rplmsgid = "";
    }
    if(isset($message['from']['first_name'])){
        $fname = $message['from']['first_name'];
    }
    else{
        $fname = "";
    }
    if(isset($message['from']['last_name'])){
        $lname = $message['from']['last_name'];
    }
    if(isset($message['date'])){
        $dt = $message['date'];
    }
    else{
        $dt = "";
    }
    if(isset($message['chat']['username'])){
        $groupusername = $message['chat']['username'];
    }
    else{
        $groupusername = "";
    }
    if(isset($message['chat']['title'])){
        $ctitle = $message['chat']['title'];
    }
    else{
        $ctitle = "";
    }    
    if(isset($message['reply_to_message']['photo'][1]['file_id'])){
        $foto = $message['reply_to_message']['photo'][1]['file_id'];
    }
    else{
        $foto = "";
    }

	//fungsi membalas pesan otomatis.
    switch (true) {		
        //membalas pesan /start
        case $pesan == '/start':
			//ini adalah fungsi mengirim pesan balasan	
            $text = "*Hello* Pesan balasan berhasil";			
       		sendApiMsg($chatid, $text);               
        break; 
		
		//membalas pesan "test"
        case $pesan == 'test':
            $text = "Test mereply pesan balasan berhasil";
       		sendApiMsg($chatid, $text, $msgid);                            
        break; 
				
        //membalas pesan "ping" atau "!ping" dll,
        case ($pesan == '!ping')||($pesan == '/ping')||($pesan == 'ping')||($pesan == 'PING')||($pesan == 'Ping'):
            $text = "🏓 pong!";
            sendApiMsg($chatid, $text, $msgid);
        break;        
    }
}