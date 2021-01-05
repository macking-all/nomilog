<?php
	include 'session.php';
?>
<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>Test</title>
	<script type="text/javascript" src="js/jquery-3.4.1.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$('#exec').click(function(){
			$.ajax({
				type:"POST",
				url:"mycallback.php",
				data:{"proc":"search"},
				success: function(data,dataType){
					$('table>tbody').empty();
					$('table>tbody').append(data.return);
					$('p#MSG').text(data.message);
					setEvents();
				},
				error:function(XMLHttpRequest,textStatus,errorThrown){
					$('table>tbody').empty();
					alert(errorThrown);
				}
			});
			return false;
		});
		$('#clear').click(function(){
			$('table>tbody').empty();
			$('p#MSG').text('');
		});
		$("#insert").click(function(){
			$("#myModal_open").prop("checked",true);
			$('#input_name_msg').text('');
			$('#input_pass_msg').text('');
			$("#input_id").text("");
			$("#input_name").val("");
			$("#input_pass").val("");
			$("#input_note").val("");
			$("#input_mode").val("insert");
			setFocus("#input_name");
		});
		$("#input_execute").click(function(){
			if(!Require()) return;
			$.ajax({
				type:"POST",
				url:"mycallback.php",
				data:{"proc":$("#input_mode").val(),"key":$("#input_id").text(),"name":$("#input_name").val(),"pass":$("#input_pass").val(),"note":$("#input_note").val()},
				success:function(data,dataType){
					$('table>tbody').empty();
					$('table>tbody').append(data.return);
					$("#myModal_close-button").prop("checked",true);
					setEvents();
					$('p#MSG').text(data.message);
				},
				error:function(XMLHttpRequest,textStatus,errorThrown){
					$('table>tbody').empty();
					alert(errorThrown);
				}
			});
		});
	});
	
	function setEvents(){
		//イベントハンドラの追加
		$('td>[id^=delete]').each(function(index,element){
			element.keyVal = $('td:eq(' + ($('td').index($(this).parent()) + 1) + ')').text();
			$(element).click(function(){
				if(!confirm('このデータを削除しますか？'))return;
				$.ajax({
					type:"POST",
					url:"mycallback.php",
					data:{"proc":"delete","key":this.keyVal},
					success:function(data,dataType){
						$('table>tbody').empty();
						$('table>tbody').append(data.return);
						$('p#MSG').text(data.message);
						setEvents()
					},
					error:function(XMLHttpRequest,textStatus,errorThrown){
						$('table>tbody').empty();
						alert(errorThrown);
					}
				});
			});
		});
		$('td>[id^=update]').each(function(index,element){
			element.keyVal = $('td:eq(' + ($('td').index($(this).parent()) + 2) + ')').text();
			$(element).click(function(){
				$("#myModal_open").prop("checked",true);
				$('#input_name_msg').text('');
				$('#input_pass_msg').text('');
				$("#input_id").text(this.keyVal);
				$("#input_name").val($('td:eq(' + ($('td').index($(this).parent()) + 3) + ')').text());
				$("#input_pass").val('');
				$("#input_note").val($('td:eq(' + ($('td').index($(this).parent()) + 4) + ')').text());
				$("#input_mode").val("update");
				setFocus("#input_name");
			});
		});
	}
	
	function Require() {
		var ret = true;
		var tmp = '';
		$('input.require').each(function(index,element){
			var id = '#' + element.id + '_msg';
			$(id).text('');
			if(element.value == '')
			{
				$(id).text('必須入力');
				tmp += id + '\r\n';
			}
			ret = ret && element.value != ''; 
		});
		return ret;
	}
	
	function setFocus(selector) {
		$(selector).focus();
		$(selector).get(0).selectionStart = 0;
	}
	
	</script>
	<style type="text/css">
		table
		{
			border-collapse:collapse;
		}
		th
		{
			background-color:#fee;
			border:solid 1px #000;
			padding:3px;
		}
		td
		{
			border:solid 1px #000;
			padding:3px;
		}
		table>tbody>tr:nth-child(2n)
		{
			background-color:#eef;
		}
		table>tbody>tr:nth-child(2n+1)
		{
			background-color:#efe;
		}
		
		table>tbody>tr>td:nth-child(3)
		{
			text-align:right;
		}
		table>tbody>tr>td:nth-child(1)
		,table>tbody>tr>td:nth-child(2)
		,table>tbody>tr>td:nth-child(4)
		,table>tbody>tr>td:nth-child(5)
		,table>tbody>tr>td:nth-child(6)
		{
			text-align:center;
		}
		
		.warn
		{
			color:red;
			text-decoration:none;
			font-style:normal;
			padding-left:10px;
		}
		.require
		{
			border-color:red;
		}
		.require::before
		{
			content:'*';
			color:red;
		}
		
		#myModal_open + label,
		.myModal_popUp,
		input[name="myModal_switch"],
		#myModal_open + label ~ label
		{
		  display: none;
		}
		#myModal_open + label,
		#myModal_close-button + label
		{
			cursor: pointer;
		}

		.myModal_popUp
		{
			animation: fadeIn 1s ease 0s 1 normal;
			-webkit-animation: fadeIn 1s ease 0s 1 normal;
		}
		#myModal_open:checked ~ #myModal_close-button + label
		{
			animation: fadeIn 2s ease 0s 1 normal;
			-webkit-animation: fadeIn 2s ease 0s 1 normal;
		}
		@keyframes fadeIn 
		{
			0% {opacity: 0;}
			100% {opacity: 1;}
		}
		@-webkit-keyframes fadeIn 
		{
			0% {opacity: 0;}
			100% {opacity: 1;}
		}

		#myModal_open:checked + label ~ .myModal_popUp 
		{
			background: #eef;
			display: block;
			width: 90%;
			height: 80%;
			position: fixed;
			top: 50%;
			left: 50%;
			border-radius:20px;
			transform: translate(-50%,-50%);
			-webkit-transform: translate(-50%,-50%);
			-ms-transform: translate(-50%,-50%);
			z-index: 998;
		}

		#myModal_open:checked + label ~ .myModal_popUp > .myModal_popUp-content 
		{
			width: calc(100% - 40px);
			height: calc(100% - 20px - 44px );
			padding: 10px 20px;
			overflow-y: auto;
			-webkit-overflow-scrolling:touch;
		}

		#myModal_open:checked + label + #myModal_close-overlay + label 
		{
			background: rgba(0, 0, 0, 0.70);
			display: block;
			width: 100%;
			height: 100%;
			position: fixed;
			top: 0;
			left: 0;
			overflow: hidden;
			white-space: nowrap;
			text-indent: 100%;
			z-index: 997;
		}

		#myModal_open:checked ~ #myModal_close-button + label 
		{
			display: block;
			background: transparent;
			text-align: center;
			font-size: 25px;
			line-height: 44px;
			width: 90%;
			height: 44px;
			position: fixed;
			bottom: 10%;
			left: 5%;
			z-index: 999;
		}
		#myModal_open:checked ~ #myModal_close-button + label::before 
		{
			content: '×';
		}
		#myModal_open:checked ~ #myModal_close-button + label::after 
		{
			content: 'CLOSE';
			margin-left: 5px;
			font-size: 80%;
		}
		.myModal_popUp>.myModal_popUp-content>label
		{
			display:inline-block;
			width:100px;
		}

		@media (min-width: 768px) 
		{
			#myModal_open:checked + label ~ .myModal_popUp 
			{
				width: 600px;
				height: 600px;
			}
			#myModal_open:checked + label ~ .myModal_popUp > .myModal_popUp-content 
			{
				height: calc(100% - 20px);
			}
			#myModal_open:checked ~ #myModal_close-button + label 
			{
				width: 44px;
				height: 44px;
				left: 50%;
				top: 50%;
				margin-left: 240px;
				margin-top: -285px;
				overflow: hidden;
			}
			#myModal_open:checked ~ #myModal_close-button + label::after 
			{
				display: none;
			}
		}
	</style>
</head>
<body>
<p id="MSG"></p>
<p><input type="button" value="表示" id="exec" /><input type="button" value="クリア" id="clear" /><input type="button" value="新規" id="insert" /></p>
<p><a href="next.php">つぎへ</a></p>
	<table>
		<thead>
			<tr>
				<th></th>
				<th></th>
				<th>ID</th>
				<th>NAME</th>
				<th>NOTE</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
	<section class="myModal">
		<input id="myModal_open" type="radio" name="myModal_switch" />
		<label for="myModal_open">開く</label>
		<input id="myModal_close-overlay" type="radio" name="myModal_switch" />
		<label for="myModal_close-overlay">オーバーレイで閉じる</label>
		<input id="myModal_close-button" type="radio" name="myModal_switch" />
		<label for="myModal_close-button"></label>
		<div class="myModal_popUp">
			<div class="myModal_popUp-content">
				<label for="input_id">ID</label><span id="input_id"></span><br />
				<label for="input_name">名前</label><input type="text" id="input_name" class="require" /><em id="input_name_msg" class="warn"></em><br />
				<label for="input_pass">パスワード</label><input type="password" id="input_pass" class="require" /><em id="input_pass_msg" class="warn"></em><br />
				<label for="input_note">備考</label><input type="text" id="input_note" /><br />
				<input type="hidden" id="input_mode" value="insert" />
				<input type="button" value="登録" id="input_execute" />
			</div>
		</div>
	</section>
</body>
</html>