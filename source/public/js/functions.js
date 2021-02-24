let test = $(".required").children('input');
console.log(test);

//clickの後は関数を指定しないといけない
$('#submitbtn').click(function () {

    //user-nameが空の時の処理
    let valtest1 = $('input[name = "user-name"]').val();
    let status = true;

    if (valtest1 === '') {
        status = false;
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
        status = false;
        $('.input-error-border2').addClass("error-border-color");
        $('#required-error-text2').text("未入力です");
    } else {
        $('.input-error-border2').removeClass("error-border-color");
        $('#required-error-text2').text('');
        console.log("入力okです2");
    }

    //ps-nameが空の時の処理
    let valtest3 = $('input[name = "ps-name1"]').val();

    if (valtest3 === '') {
        status = false;
        $('.input-error-border3').addClass("error-border-color");
        $('#required-error-text3').text("パスワードが未入力です");

        //文字列中で一致するものを検索する String のメソッドです。結果情報の配列を返します。マッチしない場合は null を返します。
        // ここはエラーメッセージを厳格に分けるために分けて書く
    } else if (!valtest3.match(/^([a-zA-Z0-9]{8,})$/)) {
        status = false;
        $('.input-error-border3').addClass("error-border-color");
        $('#required-error-text3').text("※半角英数字8文字以上を入力してください");
    }
    else {
        $('.input-error-border3').removeClass("error-border-color");
        $('#required-error-text3').text('');
        console.log("入力okです3");
    }

    //sps-nameが空の時の処理
    let valtest4 = $('input[name = "ps-name2"]').val();

    if (valtest4 === '') {
        status = false;
        $('.input-error-border4').addClass("error-border-color");
        $('#required-error-text4').text("確認用パスワードを入力してください");
    } else if (valtest4 === valtest3) {
        console.log("入力okです444444444");
    } else {
        status = false;
        $('.input-error-border4').removeClass("error-border-color");
        $('#required-error-text4').text('確認用パスワードが違います');
    }

    if (status === false) {
        console.log("全体で未入力の箇所があります");
    } else {
        console.log("正常に送信完了しました");
    }

    return status;

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

