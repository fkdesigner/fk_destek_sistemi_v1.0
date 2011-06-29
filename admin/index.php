<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<?php
/*
FK Destek Sistemi
Yazar: Firat KOYUNCU
Nick: FK Designer
Website: www.fkdesigner.com
E-Mail: fkdesigner@hotmail.com - iletisim@fkdesigner.com
Facebook Sayfasi: www.facebook.com/fkdesigner
Twitter Sayfasi: www.twitter.com/fkdesigner

Bu dosya FK Destek sisteminin bir parçasıdır.

	FK Destek Sistemi ücretsizdir: bu sistemi Free Software Foundation 
	tarafından yayınlanmış GNU Genel Kamu Lisansı 3 ya da sonrasının 
	şartları altında dağıtabilir ve/veya düzenleyebilirsiniz.

	FK Destek Sistemi faydalı olması umuduyla dağıtılmaktadır, 
	ancak hiç bir garantisi yoktur; herhangi belli bir amaca uygunluğuna 
	bile garanti veremez. Daha fazla detay için GNU Genel Kamu Lisansına 
	bakın.
	
	FK Destek Sistemi ile Genel Kamu Lisansı'nın bir kopyasını da almış 
	olmalısınız. Aksi takdirde, <http://www.gnu.org/licenses/> adresine bakın.


This file is part of FK Destek Sistemi.

    FK Destek Sistemi is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    FK Destek Sistemi is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.   
*/
include ("../ayarlar.php");
?>
<title><?php echo "$site_adi"." - "."$site_aciklama"; ?></title>
</head>
<body>
<?php
//Oturumu başlatıyoruz.
@session_start();

//Giriş yapılmamışsa, 
if(!isset($_SESSION['admin'])){ 
?>
<br /><br /><br /><br /><br />
<table width="439" height="225" border="1" align="center">
  <tr>
    <td valign="top"><br />
	<center>
	<b><font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#FF0000"><?php echo "$site_adi";?></font><br /></b>
	<i><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo "$site_aciklama";?></font></i><br />
	</center><br /><br />
	<form id="form1" name="form1" method="post" action="giris.php">
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Kullanıcı Adı : </font>
        <input type="text" name="username" size="20" maxlength = "25">
        <br />
        <br />
        <font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Şifre : </font>
          <input type="password" name="userpass" size="20" maxlength = "25">
          <blockquote>
            <blockquote>
              <p align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000099"><a href="sifremi_unuttum.php">Şifreni mi unuttun ?</a></font>              </p>
              <p align="right">
                <input type="submit" value="Giriş Yap">
              </p>
            </blockquote>
          </blockquote>
        </div>
	</form>	</td>
  </tr>
</table>
<?php
}
//Giriş yapılmışsa o zaman admin sayfasına yönlendiriyoruz.
else{
header("Location: admin.php");
}
include ("../footer.php");
?> 
</body>
</html>
