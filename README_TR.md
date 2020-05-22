# Votable
Bir model kaynağının, -isteğe bağlı olarak- kayıtlı olan kriterlere göre oylanmasını veya sadece klasik manada oylama yapılmasını sağlayan Laravel tabanlı trait yapısıdır.

[![GitHub license](https://img.shields.io/github/license/codeforms/Votable)](https://github.com/codeforms/Votable/blob/master/LICENSE)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/codeforms/Votable)
[![unstable](http://badges.github.io/stability-badges/dist/unstable.svg)](https://github.com/codeforms/Votable/releases)

> Örnek olması için Filmler ve filmlerin belirli kriterlere göre oylanmasını örnek alıyoruz. Aşağıdaki örnekte, filmler için 'Movie' ve yarışmalar için (tercihen) 'Contest' adında iki model kaynağımızın olduğunu varsayıyoruz.

### Kullanım
* ***Movie*** model dosyasına ***Votable*** trait dosyasını ekleyin. Böylece filmlerin puanlanmasını sağlıyoruz;
```php
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use CodeForms\Repositories\Vote\Votable;

class Movie extends Model
{
    use Votable;
}
```
Örnek bir film oluşturalım;
```php
<?php
Movie::create(['title' => 'Hababam Sınıfı']);

```
* (tercihen) Örnek ***Contest*** model dosyasına ***Optionable*** trait dosyasını ekleyin. Böylece yarışmadaki filmlerin belirli kriterlere göre değerlendirmesini sağlıyoruz;
```php
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use CodeForms\Repositories\Vote\Optionable;

class Contest extends Model
{
    use Optionable;
}
```
Bir yarışma kaydı oluşturalım;
```php
<?php
Contest::create(['title' => 'Yüzyılın En İyi Film Ödülleri']);

```
Oluşturduğumuz yarışma için oylama kriterlerini/seçeneklerini oluşturalım;
```php
<?php
$contest = Contest::find(1); // Yüzyılın En İyi Film Ödülleri

$contest->newVoteOption([
    'Senaryo',
    'Yönetmenlik',
    'Görüntü Yönetmenliği',
    'Müzik',
    'Ses Tasarımı',
    'Oyunculuk'
]);

# kaydettiğimiz oylama kriterlerini almak için
$contest->voteOptions; // veya $contest->voteOptions()->get()

# kriteri günceleme
$contest->updateVoteOption($option_id, $name);

# kriterleri sorgulama
$contest->hasVoteOptions();

# bir kriteri silme
$contest->deleteVoteOption($option_id);

# yarışmaya ait tüm kriterleri silme
$contest->deleteVoteOptions();
```
---
Bir filmi oylamak için;
```php
<?php
$movie = Movie::find(1);

# kriterlere göre puanlama (5 üzerinden puan/yıldız)
$movie->setVote(5, $option_id);

# klasik puanlama (5 üzerinden puan/yıldız)
$movie->setVote(5);

# filmin puanı
$movie->rating();

# filmin yüzde olarak puanı
$movie->ratingPercent();

# filmin puan ortalaması
$movie->averageRating();

# filmin puan toplamı
$movie->sumRating();

# filmin puan sorgulaması
$movie->hasVotes();

# filmin toplam değerlendirme sayısı
$movie->countVotes();

# film puanlarını tamamen silme
$movie->deleteVotes();
```