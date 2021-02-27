let test = $(".required").children('input');
console.log(test);

//clickの後は関数を指定しないといけない
$('#submitbtn').click(function () {

    //user-nameが空の時の処理
    let valtest1 = $('input[name = "user-name"]').val();
    //email-nameが空の時の処理
    let valtest2 = $('input[name = "email-name"]').val();
    //ps-name1が空の時の処理
    let valtest3 = $('input[name = "ps-name1"]').val();
    //ps-name2が空の時の処理
    let valtest4 = $('input[name = "ps-name2"]').val();
    let status = true;
    let errorborder = 'error-border-color';
    const nameExp = /^.{0,20}$/i;
    const emailExp = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/i;
    const psExp = /^[a-zA-Z0-9]{0,400}$/i;

    if (valtest1 === '') {
        status = false;
        $('.input-error-border1').addClass(errorborder);
        $('#required-error-text1').text("表示名が未入力です");
    }
    //!がない場合 nameExp.test(valtest1) 五文字までだよね??
    //!がある場合 nameExp.test(valtest1) 六文字以上だよね??
    else if (!nameExp.test(valtest1)) {
        status = false;
        $('.input-error-border1').addClass(errorborder);
        $('#required-error-text1').text("20文字以内で入力してください");
    }
    else {
        $('.input-error-border1').removeClass(errorborder);
        $('#required-error-text1').text('');
        console.log("入力okです1");
    }

    if (valtest2 === '') {
        status = false;
        $('.input-error-border2').addClass(errorborder);
        $('#required-error-text2').text("メールアドレスが未入力です");

    } else if (!emailExp.test(valtest2)) {
        $('.input-error-border2').addClass(errorborder);
        $('#required-error-text2').text("メールアドレスの形式で入力してください");
    }
    else {
        $('.input-error-border2').removeClass(errorborder);
        $('#required-error-text2').text('');
        console.log("入力okです2");
    }

    if (valtest3 === '') {
        status = false;
        $('.input-error-border3').addClass(errorborder);
        $('#required-error-text3').text("パスワードが未入力です");
    }
    //  else if (!valtest3.match(/^([a-zA-Z0-9]{0,8})$/i)) {
    //     status = false;
    //     $('.input-error-border3').addClass(errorborder);
    //     $('#required-error-text3').text("※半角英数字8文字以上を入力してください");
    // } 
    else if (!psExp.test(valtest3)) {
        status = false;
        $('.input-error-border3').addClass(errorborder);
        $('#required-error-text3').text("400文字以上は入力できません");
    }
    else {
        $('.input-error-border3').removeClass(errorborder);
        $('#required-error-text3').text('');
        console.log("入力okです3");
    }

    if (valtest4 === '') {
        status = false;
        $('.input-error-border4').addClass(errorborder);
        $('#required-error-text4').text("確認用パスワードを入力してください");
    } else if (valtest4 === valtest3) {
        console.log("入力okです444444444");
        $('.input-error-border4').removeClass(errorborder)
        $('#required-error-text4').text('');
    } else {
        status = false;
        $('.input-error-border4').addClass(errorborder);
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

