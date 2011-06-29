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

//Bize gerekli olan diğer dosyalardaki bilgileri de kullanabilmek için onları da sayfaya dahil ediyoruz.
include ("ayarlar.php");
include ("fonksiyonlar.php");
?>
<title><?php echo "$site_adi"." - "."$site_aciklama"; ?></title>
</head>
<body>
<?php
//Oturumu başlatıyoruz.
@session_start();
//Kullanıcı giriş yapmış mı diye kontrol ediyoruz, giriş yapılmamışsa giriş sayfasına yönlendiriyoruz.
if(isset($_SESSION['kullanici'])){
}
else{
echo '<br><center><b><font face="verdana" size="2" color="red">Giriş yapmadınız, giriş sayfasına yönlendiriliyorsunuz.</font><br><br>';
echo '<a href="index.php">Eğer tarayıcınız otomatik yönlendirmeyi desteklemiyorsa burayı tıklayın.</a></b></center>';
header("Location: index.php");
exit;
}

?>
<table width="1100" border="1" align="center">
  <tr>
    <td><table width="1100" height="82" border="0" align="center">
      <tr>
        <td width="719" valign="top"><b><font face="verdana" size="5" color="red"><?php echo $site_adi; ?></font></b><br />
            <i><font face="verdana" size="2" color="#333333"><?php echo $site_aciklama; ?></font></i>
          <p>&nbsp;</p></td>
          <td width="197">&nbsp;</td>
          <td width="268" valign="top"><font face="verdana" size="2" color="blue">Hoşgeldiniz</font> <font face="verdana" size="2" color="green"><u><?php echo $_SESSION['kullanici']; ?></u></font> <font face="verdana" size="2" color="#333333"> - <a href="cikis.php">Çıkış yap.</a></font> <br />
          <br /></td>
        </tr>
    </table>      </td>
  </tr>
</table><br />
<table width="1110" height="432" border="1" align="center">
  <tr>
    <td width="192" valign="top"><center><b><font face="verdana" size="2" color="red">KULLANICI YÖNETİM PANELİ</font></b></center>
      <br />
<?php
$sayfa = "kullanici.php";
?>
          <font face="verdana" size="2"> &nbsp;<b>-</b> <a href="<?php echo "$sayfa".'?sayfa=genel'; ?>">Genel</a></font> <br />
          <font face="verdana" size="2"> &nbsp;<b>-</b> <a href="<?php echo "$sayfa".'?sayfa=destek_bileti_ara'; ?>">Destek Bileti Arama</a></font> <br />
          <font face="verdana" size="2"> &nbsp;<b>-</b> <a href="<?php echo "$sayfa".'?sayfa=yeni_destek_bileti'; ?>">Yeni Destek Bileti Gönder</a></font> <br />
          <font face="verdana" size="2"> &nbsp;<b>-</b> <a href="<?php echo "$sayfa".'?sayfa=destek_biletlerim'; ?>">Destek Biletlerim</a></font> <br />
    <br />    </td>
    <td width="902" valign="top">
  <?php
//Adminin panelde gezineceği sayfaları ayarlıyoruz, böylece linkler sayesinde panele farklı sayfalar yüklenecek
@$sayfa = $_GET['sayfa'];
switch ($_GET['sayfa']){
    case 'genel':
    	include ("genel.php");
    	break;

    case 'destek_bileti_ara':
        include ("destek_bileti_ara.php");
        break;

	case 'yeni_destek_bileti':
        include ("yeni_destek_bileti.php");
        break;

    case 'destek_biletlerim':
        include ("destek_biletlerim.php");
        break;
	
	default:
		include ("genel.php");
        break;
}
?>    </td>
  </tr>
  
</table>
<p>&nbsp;</p>
<?php
include ("footer.php");
?>
</body>
</html>
