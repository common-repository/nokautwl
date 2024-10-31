<?php
namespace NokautWL\Admin;

use NokautWL\ApiKitFactory;
use NokautWL\View\Products\ShortCode\ProductsBox;

class Admin
{
    const NOKAUTWL_CONFIG_PAGE_UNIQUE_KEY = 'nokautwl-config';

    private static $initiated = false;

    public static function init()
    {
        if (!self::$initiated) {
            self::initHooks();
        }
    }

    public static function initHooks()
    {
        self::$initiated = true;

        add_action('admin_init', array(__CLASS__, 'adminInit'));
        add_action('admin_menu', array(__CLASS__, 'adminMenu'), 1);

        add_action('wp_ajax_category_search', array(__CLASS__, 'ajaxCategorySearchCallback'));
        add_action('wp_ajax_categories_get_by_ids', array(__CLASS__, 'ajaxCategoriesGetByIdsCallback'));

        add_action('admin_enqueue_scripts', array(__CLASS__, 'initNokautWLAdminJs'));
        add_action('admin_enqueue_scripts', array(__CLASS__, 'initNokautWLAdminCss'));
    }

    public static function initNokautWLAdminJs()
    {
        wp_register_script('select2.js', NOKAUTWL_PLUGIN_URL . 'public/vendor/select2/select2.js', array('jquery'), '3.4.8');
        wp_enqueue_script('select2.js');

        wp_register_script('nokaut-wl-admin.js', NOKAUTWL_PLUGIN_URL . 'public/js/nokaut-wl-admin.js', array('jquery'), NOKAUTWL_VERSION);
        wp_localize_script('nokaut-wl-admin.js', 'ajax_object',
            array('ajax_url' => admin_url('admin-ajax.php'), 'we_value' => 1234));
        wp_enqueue_script('nokaut-wl-admin.js');
    }

    public static function initNokautWLAdminCss()
    {
        wp_register_style('select2.css', NOKAUTWL_PLUGIN_URL . 'public/vendor/select2/select2.css', array(), '3.4.8');
        wp_enqueue_style('select2.css');
    }

    public static function adminInit()
    {
        Options::init();
    }

    public static function adminMenu()
    {
        $hook = add_options_page(__('NokautWL', 'NokautWL'), __('NokautWL', 'NokautWL'), 'manage_options', self::NOKAUTWL_CONFIG_PAGE_UNIQUE_KEY, array(__CLASS__, 'displayPage'));

        // top right corner help tabs
        if (version_compare($GLOBALS['wp_version'], '3.3', '>=')) {
            add_action("load-$hook", array(__CLASS__, 'adminHelp'));
        }
    }

    public static function displayPage()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        echo '<div class="wrap">';
        echo '<h2>NokautWL - konfiguracja wtyczki porównywarki cen Nokaut.pl</h2>';
        Options::form();
        echo '</div>';
    }

    public static function ajaxCategorySearchCallback()
    {
        $term = trim($_POST['term']);
        $data = array();

        $apiKit = ApiKitFactory::getApiKit();
        $categoriesRepository = $apiKit->getCategoriesRepository();
        $categories = $categoriesRepository->fetchHeaderCategoriesByTitlePhrase($term);

        foreach ($categories as $category) {
            $data[] = array(
                'id' => $category->getId() . ':' . $category->getUrl(),
                'title' => $category->getTitle()
            );
        }

        echo json_encode($data);
        die();
    }

    public static function ajaxCategoriesGetByIdsCallback()
    {
        $categories = $_POST['categories'];
        $data = array();

        $apiKit = ApiKitFactory::getApiKit();
        $categoriesRepository = $apiKit->getCategoriesRepository();

        foreach ($categories as $categoryId) {
            list($categoryId) = explode(":", $categoryId);
            if (!$categoryId) {
                continue;
            }
            $category = $categoriesRepository->fetchHeaderCategoryById($categoryId);
            $data[] = array(
                'id' => $category->getId() . ':' . $category->getUrl(),
                'title' => $category->getTitle()
            );
        }

        echo json_encode($data);
        die();
    }

    /**
     * Add help to the NokautWL page
     *
     * @return false if not the NokautWL page
     */
    public static function adminHelp()
    {
        $current_screen = get_current_screen();

        $current_screen->add_help_tab(
            array(
                'id' => 'overview',
                'title' => "Wprowadzenie",
                'content' =>
                    '<p><strong>NokautWL - wtyczka Nokaut.pl - dostawcy treści e-commerce.</strong></p>
                    <ul>Wtyczka umożliwia:
                        <li>integrację funkcjonalności pasażu handlowego z Twoim blogiem</li>
                        <li>utworzenie stron produktowych w Twojej domenie</li>
                        <li>tworzenie prostych boksów reklamowych umieszczanych w treści postów (short code)</li>
                    </ul>
                    <p>Wygląd poszczególnych elementów można całkowicie zmieniać i dostosowywać do swoich potrzeb w edytorze CSS, 
                    startowa wizualizacja jest tylko przykładem wykorzystania dostępnych danych.</p>
                    <p><strong>Ważne</strong></p>
                    <p>Utworzenie pasażu handlowego to wiele (nawet setki tysięcy!) nowych podstron dla Twojego serwisu. 
                    Może być Ci potrzebny dedykowany hosting, aby sprostać ruchowi, jaki mogą dostarczyć Twojemu blogowi 
                    roboty indeksujące wyszukiwarek, takich jak Google czy Bing.</p>
                    '
            )
        );

        $current_screen->add_help_tab(
            array(
                'id' => 'configuration',
                'title' => 'Konfiguracja',
                'content' =>
                    '<p><strong>NokautWL - konfiguracja wtyczki</strong></p>
                    <p>
                        <ul>Aby uzyskać dostęp do Nokaut Search API:
                            <li>zarejestruj się w Programie Partnerskim Nokaut.pl: 
                            <a href="https://partner.nokaut.pl/rejestracja" target="_blank">https://partner.nokaut.pl/rejestracja</a></li>
                            <li>napisz na adres partnerzy@nokaut.pl i poproś o unikalny API KEY, podając w treści wiadomości swój PID (unikalny numer Partnera, 
                            który otrzymasz po rejestracji) oraz adres WWW Twojej strony</li>
                        </ul>
                    </p>
                    <p>
                        <p>Jeśli posiadasz już klucz dostępowy do Nokaut Search API, skonfiguruj wtyczkę:</p>
                        <ul>Krok 1. Uzupełnij dane dostępowe do API:
                            <li><b>Pole API KEY:</b> tu wklej swój uniklany klucz API</li>
                            <li><b>Pole API URL:</b> tu wklej adres serwera: http://nokaut.io/api/v2/</li>
                        </ul>
                        <p>Zapisz zmiany. Po ustawieniu klucza dostępowego i API URL, zostanie wyświetlona informacja o statusie połączenia do api (Test komunikacji z API).</p>
                        <ul>Krok 2. Pozostałe ustawienia: 
                            <li><b>Pole "Strona produktów kategorii":</b> tu wpisz adres ścieżki, pod jaką ma się pojawić pasaż handlowy, np. "produkty" - pasaż handlowy utworzy się pod adresem www.twojastrona.pl/produkty</li>
                            <li><b>Pole "Strona produktu":</b> tu wpisz rozszerzenie, pod którym znajdować się strony produktowe, np. "produkt".</li>
                            <li><b>Mapowanie kategorii:</b> tu wpisz kategorie produktów, z jakich oferty chcesz mieć 
                            w swoim pasażu handlowym oraz z których będziesz chciał tworzyć boxy. Później zawsze możesz 
                            dodać lub usunąć wybrane kategorie. Po rozpoczęciu pisania system wyświetli Ci podpowiedzi, 
                            z których możesz skorzystać.</li>
                            <li><b>Pole "Ilość kolumn produktowych w widoku zdjęć":</b> dopasuj ilość produktów w wierszu pasażu do szerokości Twojej strony</li>
                        </ul>
                        <ul>Krok 3. Konfiguracja Wordpress:
                            <li><b>Ustawienia > Bezpośrednie odnośniki:</b> struktura adresów powinna być ustawiona na  wartość inną niż typ "Prosty"</li>
                        </ul>
                    </p>
                    ',
            )
        );

        $current_screen->add_help_tab(
            array(
                'id' => 'features',
                'title' => 'Integracja z blogiem',
                'content' =>
                    '<p><strong>NokautWL - integracja elemntów wtyczki z blogiem</strong></p>
                    <h3>ShortTag - link tekstowy do produktu [nokautwl-product-text-link]</h3>
                    <p>Generowany jest link tekstowy, treścią jest przekazany tekst lub nazwa produktu.
                    <ul>Opcje:
                    <li>url - adres produktu na Twoim blogu, dokładnie taki do jakiego można dojść w blogu, bez domeny, ze znakiem / na początku</li>
                    <li>tooltip - adres produktu na Twoim blogu, przyjmowane wartości (domyślnie: simple):
                        <ul>
                        <li>off - wyłączony tooltip, nad linkiem pojawi się standardowy title linka</li>
                        <li>simple - włączony standardowy, prosty tooltip</li>
                        <li>advanced - włączony rozbudowany tooltip z elementami html, ze zdjęciem, cenami</li>
                        <li>nazwa szablonu - włączony rozbudowany tooltip z zawartością wygenerowaną z podanego szablonu</li>
                        </ul>
                    </li>
                    </ul>
                    <ul>Przykłady użycia:
                    <li>[nokautwl-product-text-link url=\'/product/gry-psp/sony-eyepet.html\' type=\'off\'/]</li>
                    <li>[nokautwl-product-text-link url=\'/product/gry-psp/sony-eyepet.html\']zobacz nowy produkt![/nokautwl-product-text-link]</li>
                    <li>[nokautwl-product-text-link url=\'/product/gry-psp/sony-eyepet.html\' type=\'product/short-code/text-link/advanced.twig\'/]</li>
                    </ul>
                    <p>Tak wygląda link tekstowy:
                    <br/><img height="47px" src="' . NOKAUTWL_PLUGIN_URL . 'screenshot-2.png' . '"/>
                    </p>
                    </p>

                    <h3>ShortTag - box jednego produktu [nokautwl-product-box]</h3>
                    <p>Generowany jest box reklamowy z jednym, wybranym produktem.
                    <ul>Opcje:
                    <li>url - adres produktu na Twoim blogu, dokładnie taki do jakiego można dojść w blogu, bez domeny, ze znakiem / na początku</li>
                    </ul>
                    <ul>Przykłady użycia:
                    <li>[nokautwl-product-box url=\'/product/gry-psp/sony-eyepet.html\'/]</li>
                    </ul>
                    <p>Tak wygląda box:
                    <br/><img height="165px" src="' . NOKAUTWL_PLUGIN_URL . 'screenshot-3.png' . '"/>
                    </p>
                    </p>

                    <h3>ShortTag - boxy wielu produktów [nokautwl-products-box]</h3>
                    <p>Generowany jest box reklamowy z wieloma wybranymi produktami.
                    <ul>Opcje:
                    <li>url - adres produktów na Twoim blogu, dokładnie taki do jakiego można dojść w blogu, bez domeny, ze znakiem / na początku</li>
                    <li>limit - maksymalna ilość wyświetlanych produktów (domyślna ilość produktów: ' . ProductsBox::DEFAULT_PRODUCTS_LIMIT . ')</li>
                    <li>columns - ilość kolumn w wyświetlanych wyników (możliwe wartości: 1,2,3,4,6,12, domyślna wartość: 2)</li>
                    </ul>
                    <ul>Przykłady użycia:
                    <li>[nokautwl-products-box url=\'/category/opony/opony-zimowe/products/poziom-emisji-halasu:77.html\'/]</li>
                    <li>[nokautwl-products-box url=\'/category/opony/opony-zimowe/products/poziom-emisji-halasu:77.html\' limit=\'4\'/]</li>
                    <li>' . htmlentities('<?php echo \NokautWL\View\Products\ShortCode\ProductsBox::render($url,$limit,$columns); ?>') . ' - bezpośrednie wywołanie w pliku szablonu wordpress\'a,
                    np. w szablonie kategorii (w tym przypadku nie przekazujemy url, ustawiamy jako null, zostanie on automatycznie pobrany z bieżącej kategorii).
                    </ul>
                    <p>Przykład zapisu boxu:
                    <br/>[nokautwl-products-box url=\'/produkty/leki-na-zapalenie-stawow/--najpopularniejsze.html\' limit=\'4\'/]
                    </p>
                    <p>Tak wygląda box:
                    <br/><img height="589px" src="' . NOKAUTWL_PLUGIN_URL . 'screenshot-5.png' . '"/>
                    </p>
                    </p>
                    '
            )
        );

        $current_screen->add_help_tab(
            array(
                'id' => 'customize',
                'title' => 'Dostosowywanie wyglądu',
                'content' =>
                    '<p><strong>NokautWL - dostosowanie wyglądu elementów wtyczki</strong></p>
                    <p>Wtyczka pozwala na dostosowanie wygladu każdego elementu do swoich potrzeb.<p>
                    <p>Wtyczka domyślnie wykorzystuje system szablonów <a href="http://twig.sensiolabs.org/" target="_blank">Twig</a>
                    oraz framework <a href="http:/getbootstrap.com/" target="_blank">Bootstrap</a> </p>
                    <p>Nie należy modyfikować kodu wtyczki, gdyż uniemożliwi to bezproblemowe wykonywanie jej aktualizacji
                    w przyszłości. Należy skopiować odpowienie pliki z wtyczki (wp-content/plugins/nokaut-wl/templates/)
                    do utworzonego katalogu aktywnego motywu (wp-content/themes/AKTYWNY_MOTYW/nokaut-wl/templates/) Wordpress,
                    dopiero skopiowane pliki szablonów są bazą do indywidualnych zmian.</p>
                    <ul>Kolejność wczytywania plików szablonów wtyczki:
                    <li>wp-content/themes/AKTYWNY_MOTYW/nokaut-wl/templates/</li>
                    <li>wp-content/plugins/nokaut-wl/templates/</li>
                    </ul>

                    <ul>Kolejność wczytywania plików CSS wtyczki:
                    <li>wp-content/themes/AKTYWNY_MOTYW/nokaut-wl/public/css/nokaut-wl.css</li>
                    <li>wp-content/plugins/nokaut-wl/public/css/nokaut-wl.css</li>
                    </ul>

                    <ul>Kolejność wczytywania plików javascript wtyczki:
                    <li>wp-content/themes/AKTYWNY_MOTYW/nokaut-wl/public/js/nokaut-wl.js</li>
                    <li>wp-content/plugins/nokaut-wl/public/js/nokaut-wl.js</li>
                    </ul>

                    <p>Alternatywą dla kopiowania pliów CSS jest stosowanie bardziej prezyzyjnych selektorów dla elementów HTML we własnych plikach CSS.</p>
                    ',
            )
        );

        // Help Sidebar
        $current_screen->set_help_sidebar(
            '<p><strong>Więcej informacji</strong></p>' .
            '<p><a href="http://nokaut.pl/" target="_blank">nokaut.pl</a></p>' .
            '<p><a href="mailto:partnerzy@nokaut.pl" target="_blank">partnerzy@nokaut.pl</a></p>'
        );
    }
}