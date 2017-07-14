<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
    <title>THSarabun</title>
    <link rel="stylesheet" type="text/css" href="../TH Sarabun New/fonts/thsarabunnew.css">
    <style>

        html {
            font-family: 'THSarabunNew';
			font-size: 62.5%;*/
        }
		body {
			/*font-size: 1.125em;
			font-size: 1em;*/
		}
		h1, .h1{font-size: 3.6em; font-weight: bold;}
		h2, .h2{font-size: 3.0em; font-weight: bold;}
		h3, .h3{font-size: 2.4em; font-weight: bold;}
		h4, .h4{font-size: 1.8em; font-weight: bold;}
		h5, .h5{font-size: 1.4em; font-weight: bold;}
		h6, .h6{font-size: 1.2em; font-weight: bold;}
		strong, .bold{
			font-weight: bold;
		}
		em, .italic {
    		font-style: italic;
		}
		strong>em, em>strong, .bolditalic {
    		font-weight: bold;
    		font-style: italic;
		}


    </style>
  </head>
  <body>
    <article>
        <h1>THSarabun</h1>Normal
        <table>
          <tr align="center">
            <th>Size</th>
            <th>Normal</th>
            <th>Bold</th>
            <th>Italic</th>
            <th>BoldItalic</th>
          </tr>
          <?php for($i=1; $i<=6; $i++){?>
          <tr class="h<?php echo $i?>">
            <td>h<?php echo $i?></td>
            <td>กขฃคฅฆงจฉชซฌญฎฏฐฑฒณดตถทธนบป มนุษย์<br>
              ๑๒๓๔๕๖๗๘๙๐
              <br>
              abcdefghijklmnopqrstuvwxyz<br>
ABCDEFGHIJKLMNOPQRSTUVWXYZ<br>
1234567890!@#$%^&*()`~{}[]+=:;'"‘’“” </td>
            <td class="bold">กขฃคฅฆงจฉชซฌญฎฏฐฑฒณดตถทธนบป<br>
๑๒๓๔๕๖๗๘๙๐ <br>
abcdefghijklmnopqrstuvwxyz<br>
ABCDEFGHIJKLMNOPQRSTUVWXYZ<br>
1234567890!@#$%^&*()`~{}[]+=:;'"‘’“” </td>
            <td class="italic">กขฃคฅฆงจฉชซฌญฎฏฐฑฒณดตถทธนบป<br>
๑๒๓๔๕๖๗๘๙๐ <br>
abcdefghijklmnopqrstuvwxyz<br>
ABCDEFGHIJKLMNOPQRSTUVWXYZ<br>
1234567890!@#$%^&*()`~{}[]+=:;'"‘’“” </td>
            <td class="bolditalic">กขฃคฅฆงจฉชซฌญฎฏฐฑฒณดตถทธนบป<br>
๑๒๓๔๕๖๗๘๙๐ <br>
abcdefghijklmnopqrstuvwxyz<br>
ABCDEFGHIJKLMNOPQRSTUVWXYZ<br>
1234567890!@#$%^&*()`~{}[]+=:;'"‘’“” </td>
          </tr>
          <?php }?>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
    </article>
  </body>
</html>
