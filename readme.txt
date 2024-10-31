=== NokautWL ===
Contributors: Nokaut.pl Sp z o.o.
Tags: nokaut
Requires at least: 3.0.1
Tested up to: 4.9.5
Stable tag: 1.3.1
License: MIT
License URI: http://opensource.org/licenses/MIT

Integration with nokaut.pl search api, easy configuration, customizable templates.

== Description ==

Wtyczka w prosty sposób integruje Twój blog z Nokaut.pl. Monetyzuj ruch na swoim blogu poprzez umieszczenie na nim
dopasowanych ofert z Nokaut.pl Instalacja wtyczki i umieszczenie ofert sklepów na swoim blogu wystarczy, by zacząć zarabiać!

Możliwości:

* integracja funkcjonalności pasażu handlowego z Twoim blogiem
* dostępność stron produktowych w Twojej domenie
* tworzenie prostych boksów reklamowych umieszczanych w treści postów (short tags)

Wtyczka jest idealnym rozwiązaniem dla posiadaczy blogów o różnej tematyce (Moda, AGD, RTV, Elektronika i narzędzia, Sport i hobby, etc)
i daje szerokie spektrum kilku milionów ofert do prezentacji. Partner otrzymuje od 50 do nawet 70% prowizji za każde przekierowanie lub
transakcję w sklepie, do którego skierował użytkownika.

Przykładowe ekrany z działania wtyczki znajdziesz w sekcji 'Screenshots'.

Masz pytania przed instalacją wtyczki? Skontaktuj się z Nokaut.pl pod adresem partnerzy@nokaut.pl.

**Ważne**

Utworzenie pasażu handlowego to wiele (nawet setki tysięcy!) nowych podstron dla Twojego serwisu. Może być Ci potrzebny
dedykowany hosting, aby sprostać ruchowi, jaki mogą dostarczyć Twojemu blogowi roboty indeksujące wyszukiwarek, takich
jak Google czy Bing.

**Aspekty techniczne i prawne**

Wtyczka korzysta z biblioteki API KIT Nokaut.pl (https://github.com/nokaut/api-kit).
Bibioteka API KIT Nokaut.pl jest udostępniana na licencji [MIT](https://github.com/nokaut/api-kit/blob/master/LICENSE).

Wtyczka umożliwia łatwe skorzystanie z szablonów [Twig templating engine](http://twig.sensiolabs.org/).
Przeczytaj [dokumentację Twig](http://twig.sensiolabs.org/documentation) w celu wyjaśnienia zagadnień technicznych.
Przeczytaj [licencję Twig](http://twig.sensiolabs.org/license) wyjaśniającą aspekty prawne.

Wtyczka integruje bibliotekę (CSS, JS) [Bootstrap](http://getbootstrap.com/).
Kod Bootstrap udostępniany jest na licencji [MIT](https://github.com/twbs/bootstrap/blob/master/LICENSE).
Można łatwo zaprzestać korzystania z biblioteki Bootstrap, zmieniając szablony.

= English version =

Plugin simply integrates nokaut.pl products with wordpress blog. Monetize traffic to your blog by placing on it matching products from Nokaut.pl.
Start making money with installing the plugin!

Features:

* shopping mall integration with your blog
* products pages
* products short tags for posts (product text link, product box, products boxes)

This plugin is ideal for owners of blogs on various topics (fashion, household appliances, electronics and tools, sport and hobby, etc)
and offers a wide range of several million products for presentation. Partner receives from 50 to up to 70% commission for each redirection to store or
transaction in the store.

Example plugin screens you can find in 'Screenshots' section.

If you have any questions before installing the plugin, contact Nokaut.pl at partnerzy@nokaut.pl.

**Caution**

Shopping mall integration will add many (even hundreds of thousands!) new pages to your blog. This may cause that you will need
dedicated hosting solution, which will be able to handle the traffic from search engines crawlers like Google or Bing.

**Technical and legal aspects**

This plugin uses Nokaut.pl Search API KIT (https://github.com/nokaut/api-kit).
Nokaut.pl Search API KIT code is licensed under [MIT](https://github.com/nokaut/api-kit/blob/master/LICENSE) license.

This plugin provides a simple way for you to use the [Twig templating engine](http://twig.sensiolabs.org/) with plugin templates.
Read [Twig documentation](http://twig.sensiolabs.org/documentation) for more technical details.
Read [Twig license](http://twig.sensiolabs.org/license) to clarify the legal aspects.

This plugin integrates [Bootstrap](http://getbootstrap.com/) framework.
Bootstrap code is licensed under [MIT](https://github.com/twbs/bootstrap/blob/master/LICENSE) license.
You can simply turn off Bootstrap integration with template changes.

== Installation ==

= Instalacja =

Zaloguj się do swojego panelu administratora w Wordpressie, wejdź do zakładki 'Wtyczki > Dodaj nową > Szukaj wtyczek' i wpisz
w wyszukiwarkę 'Nokaut WL' - kliknij 'Zainstaluj wtyczkę'. Przeczytaj pomoc i skonfiguruj wtyczkę ('/wp-admin/options-general.php?page=nokautwl-config').

**Metoda alternatywna**

1. Pobierz plugin ze strony https://wordpress.org/plugins/nokautwl/
1. Rozpakuj archiwum ZIP na swoim komputerze. Wgraj katalog 'nokaut-wl/' ze swojego komputera do katalogu '/wp-content/plugins/' na swoim serwerze
2. Aktywuj wtyczkę w panelu administratora Wordpress, w sekcji 'Wtyczki / Plugins'
3. Przeczytaj pomoc i skonfiguruj wtyczkę ('/wp-admin/options-general.php?page=nokautwl-config')

== Frequently Asked Questions ==

**Najczęściej zadawane pytania**

= Czy korzystanie z wtyczki jest płatne? =

Nie, wtyczka jest bezpłatna - zarówno instalacja, jak i korzystanie z niej. Jest ona narzędziem pomocniczym we współpracy
między Nokaut.pl, a Partnerami (właścicielami blogów).

= Czy pobranie wtyczki obliguje mnie do korzystania z niej? =

Nie, po pobraniu wtyczki możesz ją uruchomić, a następnie wyłączyć jeśli nie spełni Twoich oczekiwań.

= Jak wykorzystać wtyczkę do stworzenia własnego pasażu handlowego? =

Po pobraniu wtyczki, uruchomieniu jej i wybraniu kategorii produktów - pod wybranym adresem automatycznie pojawi się
pasaż handlowy z produktami z tych kategorii. Możesz dodać ją do Menu na swoim blogu, aby ułatwić trafienie do produktów
użytkownikom i robotom indeksującym, takim jak Google.

= W sieci wiele jest programów partnerskich i afiliacyjnych, dlaczego mam korzystać z wtyczki Nokaut? =

Nokaut.pl może dostarczyć kilka milionów ofert na Twoją stronę i jako jedyny program oferuje direct clicki
(bezpośrednie przekierowania do sklepów) - użytkownik jest przenoszony od razu do sklepu, a nie na strony
pośrednie - jak ma to miejsce w innych programach. Dzięki temu zarabiasz na każdym przekierowaniu. Partner - czyli
właściciel bloga - zarabia 50% od każdego przekierowania do sklepu lub część prowizji od transakcji w sklepie.

= Jak wygląda rozliczenie za reklamy? =

Aby korzystać z wtyczki potrzebujesz założyć konto w Programie Partnerskim Nokaut:
https://partner.nokaut.pl/rejestracja. Po pozytywnej weryfikacji Twojego serwisu możesz uzyskać unikalny klucz
pozwalający do korzystania z wtyczki (aby go otrzymać napisz na partnerzy@nokaut.pl). W panelu Partnera będziesz miał
stały wgląd w rozliczenia, a po uzbieraniu środków przekraczających 100 zł netto będziesz mógł wysłać do Nokaut rachunek
(osoby prywatne) lub fakturę (firmy).

= Jak uruchomić wtyczkę po pobraniu? =

Aby uruchomić wtyczkę po instalacji, wejdź w zakładkę Ustawienia > Nokaut WL, w pole API KEY wpisz swój unikalny klucz,
a w polu API URL: http://nokaut.io/api/v2/.

= Czy żeby korzystać z wtyczki muszę umieć programować? =

Nie, wtyczka została stworzona z myślą o prostej, niemal automatycznej integracji Nokaut.pl z blogiem, bez konieczności
posiadania wiedzy programistycznej. Jednak im większa wiedza o działaniu serwisów internetowych i ich pozycjonowaniu,
tym większe korzyści można osiągnąć.

= Jak instalacja wtyczki wpłynie na wygląd mojej strony? =

Wtyczka spowoduje pojawienie się ofert wyłącznie w wybranych przez Ciebie miejscach, a w przypadku pasażu
handlowego - pod wybranym przez Ciebie adresem (rozszerzeniem Twojej strony).

= Chcę współpracować z Nokaut, ale nie chcę instalować żadnej wtyczki =

Zarejestruj się w Programie Partnerskim Nokaut.pl: https://partner.nokaut.pl/rejestracja - w panelu Partnera znajdziesz
inne możliwości reklamowe, takie jak linki partnerskie czy widgety.

Nie znalazłeś odpowiedzi na swoje pytanie? Napisz do nas na partnerzy@nokaut.pl

== Screenshots ==

1. Konfiguracja pluginu. (Plugin configuration.)
2. ShortTag - link tekstowy do produktu. (ShortTag - Text link to product.)
3. ShortTag - boks z jednym produktem. (ShortTag - single product box.)
4. ShortTag - boks z wieloma produktami w jednym wierszu. (ShortTag - multiple products box in one row.)
5. ShortTag - boks z wieloma produktami w dwóch wierszach. (ShortTag - multiple products box in two rows.)
6. Pasaż handlowy. (Shopping mall.)

== Changelog ==

= 1.3.1 =
* Fix product photo url protocol

= 1.3.0 =
* Updated plugin readme and configuration help
* Fix product page witch iterable properities

= 1.2.1 =
* Add timeouts to API Client
* Change API host to nokaut.io

= 1.2.0 =
* Updated readme.txt
* Updated plugin configuration help
* Custom robots noindex
* Check if category is enabled
* Fix products and offers title encoding
* Change image host, sizes, file names
* Configurable products grid columns number
* Default API URL
* Handle no product found
* Fix enqueue scripts

= 1.1.0 =
* Update/fix admin documentation
* Fix product url cleaning from WP url
* Fix list product click url

= 1.0.2 =
* Click url change to nokaut.click
* Update tested WordPress version

= 1.0.1 =
* Readme changes

= 1.0.0 =
* Initial version

== Upgrade Notice ==

= 1.0.0 =
* Initial version, no upgrade needed.