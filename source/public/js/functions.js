let test = $(".required").children('input');
console.log(test);

//clickの後は関数を指定しないといけない
$('#submitbtn').click(function () {
    //トリガーが必要
    let valtest = $('input[name = "user-name"]').val();

    if (valtest === '') {
        console.log("あああああああああああ");
    } else {
        console.log("いいいいいいいいいい");
    }

});

//一個のinput属性で完璧に動作するようにする
//0203やることinputタグ中にエラーメッセージの表示する(値を設定する)

