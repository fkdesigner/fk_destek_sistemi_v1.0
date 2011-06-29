<?php
/*
FK Destek Sistemi
Yazar: Firat KOYUNCU
Nick: FK Designer
Website: www.fkdesigner.com
E-Mail: fkdesigner@hotmail.com - iletisim@fkdesigner.com
Facebook Sayfasi: www.facebook.com/fkdesigner
Twitter Sayfasi: www.twitter.com/fkdesigner

Bu dosya FK Destek sisteminin bir parçasidir.

	FK Destek Sistemi ücretsizdir: bu sistemi Free Software Foundation 
	tarafindan yayinlanmis GNU Genel Kamu Lisansi 3 ya da sonrasinin 
	sartlari altinda dagitabilir ve/veya düzenleyebilirsiniz.

	FK Destek Sistemi faydali olmasi umuduyla dagitilmaktadir, 
	ancak hiç bir garantisi yoktur; herhangi belli bir amaca uygunluguna 
	bile garanti veremez. Daha fazla detay için GNU Genel Kamu Lisansina 
	bakin.
	
	FK Destek Sistemi ile Genel Kamu Lisansi'nin bir kopyasini da almis 
	olmalisiniz. Aksi takdirde, <http://www.gnu.org/licenses/> adresine bakin.


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
//guvenlik_kodu: Bizim için direk bir güvenlik kodu resmi olusturuyor ve oturum degiskeni olarak atiyor.
function guvenlik_kodu () {
//rand(sayi,sayi) belirtilen sayilar arasindan bir sayi seçiyor,
//md5 ile sifreleme yapiyor,
//substr ile belirtilen karakter kadar karakteri aliyor.
 $sifre = substr(md5(rand(1000,999999999999)),-6);
 if ($sifre) {
  session_start();
  $_SESSION["guvenlik_kodu"] = $sifre;
  $width  = 100;
  $height =  30;
  $resim  = ImageCreate($width,$height);
  $beyaz  = ImageColorAllocate($resim, 255, 255, 255);
  $rand   = ImageColorAllocate($resim, rand(0,255), rand(0,255), rand(0,255));
  ImageFill($resim, 0, 0, $rand);
  ImageString($resim, 5, 24, 13, $_SESSION["guvenlik_kodu"], $beyaz);
  ImageLine($resim, 100, 19, 0, 19, $beyaz);
   header("Content-Type: image/png");
  ImagePng($resim);
  ImageDestroy($resim);
 }
}
guvenlik_kodu();
?>