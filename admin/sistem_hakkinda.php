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
?>
<title><?php echo "$site_adi"." - "."Sistem Hakkında"; ?></title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style2 {
	font-size: 14px;
	font-weight: bold;
	color: #000099;
}
.style3 {color: #FF0000}
.style4 {color: #0000FF}
.style5 {color: #333333}
.style6 {color: #00FFFF}
.style8 {font-size: 14px; font-weight: bold; color: #006600; }
.style9 {font-size: 14px; font-weight: bold; color: #FF0000; }
-->
</style>
</head>
<body>
  <p>
<?php
//Oturumu başlatıyoruz.
@session_start();
//Admin giriş yapmış mı diye kontrol ediyoruz, giriş yapılmamışsa giriş sayfasına yönlendiriyoruz.
if(isset($_SESSION['admin'])){
}
else{
echo '<br><center><b><font face="verdana" size="2" color="red">Giriş yapmadınız, giriş sayfasına yönlendiriliyorsunuz.</font><br><br>';
echo '<a href="index.php">Eğer tarayıcınız otomatik yönlendirmeyi desteklemiyorsa burayı tıklayın.</a></b></center>';
header("Location: index.php");
exit;
}
?> 
<span class="style1"><span class="style2">FK Destek Sistemi</span><br />
<br />
FK Destek Sistemi, size özel olarak 0'dan kodlanmış bir destek yönetim sistemidir. Oyun sunucularında, elektronik mağazalarda, e-şirketlerin web sitelerinde ve çeşitli yerlerde destek sitesi amaçlı kullanılmak için ve destek bileti sistemi (ticket system) düşünülerek yapılmıştır. Yapımı Fırat Koyuncu (FK Designer)'ya aittir.<br />
<br />
<span class="style9">FK Destek Sistemi 1.0 (Sınırlı Sürüm):</span><br />
Sizin şu anda kullandığınız sürüm budur. FK Destek Sistemi ilk olarak 1.0 versiyonuyla çıkartıldı. Versiyon üzerinde denemeler, beta ve stress testleri ile açık ve güvenlik testleri yapılarak geliştirmeye çalıştık. Sonuç itibariyle sınırlı sürümü oluşturacak olan 1.0 sürümünü çıkarttık. Ama şunu bildirmeliyiz ki sınırsız sürüm her zaman bir adım daha önde olacaktır. Sınırlı sürüm yalnızca HTML ve PHP kullanılarak yapılmıştır. Sınırsız sürümde kullanmayı düşündüğümüz özelliklerin bir çoğu buraya eklenmemiştir. Bu sürüm yalnızca tanıtım ve temel testler için yapılmıştır ve yine bu sürüm açık kaynak kodlu olarak dağıtılacaktır. Bu sürümü yalnızca güvenlik gibi önemli açık, sorun ya da güncelleme gerektiği takdirde güncelleyip geliştireceğiz. Dolayısıyla sürüm muhtemelen 1.x versiyonlarıyla devam edecektir.
<br />
<br />
<span class="style8">FK Destek Sistemi 2.0 (Sınırsız Sürüm):</span><br />
Bu sistem takımımızın özel olarak oturup tasarladığı ve 1.0'ı emülatör gibi kullanarak %45'inin üzerine inşaa ettiği özel bir sistemdir.Temelinden (1.0) farklı olarak bu sürüm HTML ve PHP dışında JAVA ve PHOTOSHOP kullanılarak hızlandırılmıştır. Yine bu sürümde görsellik tamamen ön plana çıkartılmış ve güvenlik seviyesi oldukça arttırılmıştır. Bu sürüm takımımızın alternatif ve hoş fikirleri ile çeşitli sürümlerde geliştirileceği gibi bu sürüme sahip herkese de teknik destek verilecektir. 1.0'da olmayan ve asıl yönetim amacıyla kullanmak için aradığınız özellikler tamamen 2.0 üzerinde bulunmaktadır. Sınırsız sürümü yalnızca bizden isteyin lütfen. Ve bu sürümün bizden başka bir yerde açık/kapalı bir şekilde dağıtılması, kopyalanması, belli içeriğinin alınması yasaktır.<br />
<br />
Üstteki yazıların her ikisi de yazılırken 1.0 sürümü henüz bitmemişti, bu yüzden ikisi hakkında gerçekten ayrıntılı bilgi almak için web sitemizi ya da Sınırsız Sürüm 2.0'ın yönetim panelini ziyaret edin.<br />
<br />
<strong><span class="style3">FK</span> <span class="style4">Designer</span><br />
</strong><span class="style5">Web Geliştirme Takımı </span><strong><br />
Fırat Koyuncu</strong> <strong>(Takım Lideri)<br />
<span class="style3">Web:</span> <a href="http://www.fkdesigner.com">http://www.fkdesigner.com</a><br />
<span class="style4">Facebook:</span> <a href="http://www.facebook.com/fkdesigner">http://www.facebook.com/fkdesigner</a><br />
<span class="style6">Twitter:</span> <a href="http://www.twitter.com/fkdesigner">http://www.twitter.com/fkdesigner</a></strong><br />
<strong><em><br />
Lütfen kendimizi ve sistemlerimizi geliştirebilmemiz için bize kullanımınız sonucu geri bildirim yapın. Teşekkür ederiz. </em></strong></span>
</body>
</html>
