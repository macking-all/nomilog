let test = $(".required").children('input');
console.log(test);

//clickの後は関数を指定しないといけない
$('#submitbtn').click(function () {

    //user-nameが空の時の処理
    let valtest1 = $('input[name = "user-name"]').val();
    let status;

    if (valtest1 === '') {
        // Array.prototype.push.call(status, 1);
        status = "ng";
        $('.input-error-border1').addClass("error-border-color");
        $('#required-error-text1').text("未入力です");
    } else {
        $('.input-error-border1').removeClass("error-border-color");
        $('#required-error-text1').text('');
        console.log("入力okです1");
    }

    //email-nameが空の時の処理
    let valtest2 = $('input[name = "email-name"]').val();

    if (valtest2 === '') {
        status = "ng";
        $('.input-error-border2').addClass("error-border-color");
        $('#required-error-text2').text("未入力です");
    } else {
        $('.input-error-border2').removeClass("error-border-color");
        $('#required-error-text2').text('');
        console.log("入力okです2");
    }

    //ps-nameが空の時の処理
    let valtest3 = $('input[name = "ps-name"]').val();

    if (valtest3 === '') {
        status = "ng";
        $('.input-error-border3').addClass("error-border-color");
        $('#required-error-text3').text("未入力です");
    } else {
        $('.input-error-border3').removeClass("error-border-color");
        $('#required-error-text3').text('');
        console.log("入力okです3");
    }

    //sps-nameが空の時の処理
    let valtest4 = $('input[name = "sps-name"]').val();

    if (valtest4 === '') {
        status = "ng";
        $('.input-error-border4').addClass("error-border-color");
        $('#required-error-text4').text("再入力したパスワードが違います");
    } else {
        $('.input-error-border4').removeClass("error-border-color");
        $('#required-error-text4').text('');
        console.log("入力okです4");
    }

    if (status === "ng") {
        console.log("全体で未入力の箇所があります");
        return false;
    } else {
        console.log("正常に送信完了しました");
    }

});

//新規登録画面遷移テスト利用中
$('#aaa').click(function () {
    window.location.href = "../master/newuserregistration.html";
});

//キャンセルボタン
$('#cancelbtn').click(function () {
    // console.log(`キャンセルボタンテスト`);
    // return false;
    window.location.href = "../master/usermaster.html";
});


//一個のinput属性で完璧に動作するようにする
//0203やることinputタグ中にエラーメッセージの表示する(値を設定する)

