//Element取得

        //form
        const form = document.getElementById("form");
        //form element
        const name = document.getElementById("user_name");
        const email = document.getElementById("email");
        //const password = document.getElementById("password");
        //const password2 = document.getElementById("confirm_pass");

        //error message
        const name_error_message = document.getElementById("name-error-message");
        const email_error_message = document.getElementById("email-error-message");
        //const pass_error_message = document.getElementById("pass-error-message");

        //button
        const btn = document.getElementById("btn");

        //バリデーションパターン
        //const passExp = /^[a-z\d]{8,30}$/i; //8文字以上30文字以下
        const emailExp = /^[a-z]+@[a-z]+\.[a-z]+$/;

        //初期状態設定
        btn.disabled = true;

        //event

        //name
        name.addEventListener("keyup", (e) => {
            if (name.value === '') {
                name_error_message.style.display = "block";
            } else { 
                name_error_message.style.display = "none";
            }
            checkSuccess();
        });

        //email
        email.addEventListener("keyup", (e) => {
            if (emailExp.test(email.value)) {
                email_error_message.style.display = "none";
            } else {
                email_error_message.style.display = "inline";
            }
            checkSuccess();
        });

        //ボタンのdisabled制御
        const checkSuccess = () => {
            if (name.value && email.value) {
                    btn.disabled = false;
            } else {
                    btn.disabled = true;
            }
        }

        //submit
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            form.method = "post";
            form.action = "entry.php";
            form.submit();
        });
