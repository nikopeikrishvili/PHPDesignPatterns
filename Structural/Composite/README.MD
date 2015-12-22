#Composite

##პრობლემა

<p>როგორც ვიცით შვილობილი კლასები მშობელი კლასებისგან იმკვიდრებენ მეთოდებს და თვისებებს (გარკვეული ინკაფსულაციის დონეზე)
ამას ჩვენ გამოვიყენებთ შვილობილი კლასებისთვის რომელთაც უნდა ქონდეთ გარკვეული ფუნქციონალი

</p>
![alt tag](https://raw.github.com/nikopeikrishvili/PHPDesignPatterns/master/Structural/Composite/files/Composite_1.png)
<p>
აბსტრაქტული კლასი Lesson ახდენს ლექციების მოდელირებას კოლეჯში მას გააჩნია 2 აბსტრაქტული მეთოდი cost() და chargeType().
დიაგრამაზე ნაჩვენებია 2 კლასი რომელიც ახდენს Lesson კლასის რეალიზაციას FixedPriceLesson და TimedPriceLesson რომელთა დავალება არის 
 ლექციების საფასურის კალკულაცია იმისდა მიხედვით ფიქსირებული საფასურის ლექციაა თუ საათობრივი გადახდაა.

მემკვიდრეობითობის ამ სქემის საშუალებით ჩვენ შეგვიძლია მარტივად შევცვალოთ ლექციის გადახდის ტიპის რეალიზაცია, კლიენტის კოდს ეცოდინება მხოლოდ ის რომ
მას ურთიერთობა აქვს Lesson ტიპის ობიექტთან ამიტომაც მექანიზმის დეტალები იქნება გამჭირვალე.
მაგრამ წარმოვიდგინოთ რომ სქემაში შემოგვაქვს კიდე 2 ტიპი რომელსაც შეიძლება დაესწროს სტუდენტი მაგალითად სემინარი და ლექცია.
</p>
![alt tag](https://raw.github.com/nikopeikrishvili/PHPDesignPatterns/master/Structural/Composite/files/Composite_1.png)
<p>
მათთაც ფასების კალკულაცია შეიძლება განსხვავებული ქონდეთ მიუხედავად იმისა საათობრივი გადახდაა თუ ფიქსირებული.
ნებისმიერ შემთხვევაში თუ გადახდის სტრატეგია ორივე ტიპისთვის იქნება ერთი და იგივე ამ შემთხვევაში ვერ ვცდებით კოდის დუბლირებას.

ამ ეტაპზე რომ ავცდეთ კოდის დუბლირებას უნდა შემოვიღოთ პირობითი ოპერატორები მშობელ Lesson კლასში, ანუ შვილობილი კლასიდან
უნდა ავიტანოთ კალკულაცია მშობელ კლასსში.
 მაგრამ ეს მთლიანად ეწინააღმდეგება ტრადიციული რეფაქტორინგის
 პრინციპებს, აი როგორ გამოყურება ჩვენი კოდი თუ შემოვიტანთ პირობით ოპერატორებს:
</p>
```PHP
abstract class Lesson {
    protected   $duration;
    const       FIXED = 1;
    const       TIMED = 2;
    private     $costType;

    function __construct($duration,$constType=1) {
        $this->duration = $duration;
        $this->costType = $constType;
    }
    function cost() {
        switch($this->costType) {
            case  SELF::TIMED :
              return (5 * $this->duration);
              break;
            case SELF::FIXED :
              return 30;
              break;
            default :
              $this->costType = SELF::FIXED;
              return 30;
        }
    }
    function chargeType() {
        switch($this->costType) {
            case  SELF::TIMED :
              return "საათობრივი გადახდა";
              break;
            case SELF::FIXED :
              return "ფიქსირებული გადახდა";
              break;
            default :
              $this->costType = SELF::FIXED;
              return "ფიქსირებული გადახდა";
        }
    }
// Lesson კლასის სხვა მეთოდები ...
}

class Lecture extends Lesson {
 // ლექციისთვის განკუთვნილი სხვა ფუნქციონალი
}

class Seminar extends Lesson {
 // სემინარისთვის განკუთვნილი სხვა ფუნქციონლაი
}
```
<p>და აი როგორ უნდა ვიმუშავოთ ამ კლასებთან : </p>
```php
$lecture = new Lecture(5, Lesson::FIXED);
echo $lecture->cost().' '.$lecture->chargeType();

$seminar = new Seminar(3, Lesson::TIMED);
echo $seminar->cost().' '.$seminar->chargeType();

```
<p>შედეგი : </p>
<hr />
30 ფიქსირებული გადახდა
<br />
15 საათობრივი გადახდა
<hr />
