<?php


echo <<<_HEAD
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>This is smile_draw.php</title>
<script type="text/javascript">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="0; url=./draw_my_smile.php">;
</script>
<script type="text/javascript">
function validate(form) {
     fail = validatefield(form.smile.value)
       if(fail =="") { return true }
         else {alert(fail); return false}
   }
function validatefield(field) {
  if(field == "")  
return "No smile string entered "
else { return "" }
}
</script>
</head>
_HEAD ;

echo <<<_content
<body>

_content;

echo <<<_EOF

<h3>Give me a smile please! &#x1F603;</h3>
Credit to <a target="_blank" href="https://smilesdrawer.surge.sh/use.html">https://smilesdrawer.surge.sh/use.html</a>
<br/> <font style="font-size: 20px;">An example for you: [H]OC2=C([H])C([H])=C([H])C([H])=C2(C([H])=NN([H])C(=O)C1=C([H])C([H])=NC([H])=C1([H]))</font>
   <form action="draw_my_smile.php" method="post" onSubmit="return validate(this)" target="_blank">
   <p>Smile string <input type="text" size="100" name="smile" /> </p>
   <p><input type="Submit" value="Convert smile to structure!" /></p>
  </form>

_EOF;

echo <<<_TAIL

</body>
</html>
_TAIL;


?>
