<?php

/**
 * Classe utilitaire : cette classe ne contient que des méthodes statiques qui peuvent être appelées
 * directement sans avoir besoin d'instancier un objet Utils.
 * Exemple : Utils::redirect('home'); 
 */
class Utils
{
    /**
     * Convertit une date vers le format de type "Samedi 15 juillet 2023" en francais.
     * @param DateTime $date : la date à convertir.
     * @return string : la date convertie.
     */
    public static function convertDateToFrenchFormat(DateTime $date): string
    {
        // Attention, s'il y a un soucis lié à IntlDateFormatter c'est qu'il faut
        // activer l'extention intl_date_formater (ou intl) au niveau du serveur apache. 
        // Ca peut se faire depuis php.ini ou parfois directement depuis votre utilitaire (wamp/mamp/xamp)
        $dateFormatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::FULL);
        $dateFormatter->setPattern('EEEE d MMMM Y');
        return $dateFormatter->format($date);
    }

    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    public static function hasUserConnected(): bool
    {
        // On vérifie que l'utilisateur est connecté.
        return !empty($_SESSION['idUser']);
    }

    /**
     * Récupère l'id de l'utilisateur connecté.
     * @return int
     */
    public static function getCurrentIdUser(): int
    {
        // On vérifie que l'utilisateur est connecté.
        return $_SESSION['idUser'];
    }

    /**
     * Redirige vers une URL.
     * @param string $action : l'action que l'on veut faire (correspond aux actions dans le routeur).
     * @param array $params : Facultatif, les paramètres de l'action sous la forme ['param1' => 'valeur1', 'param2' => 'valeur2']
     * @return void
     */
    public static function redirect(string $action, array $params = []): void
    {
        $url = "index.php?action=$action";
        foreach ($params as $paramName => $paramValue) {
            $url .= "&$paramName=$paramValue";
        }
        header("Location: $url");
        exit();
    }

    /**
     * Cette méthode retourne le code js a insérer en attribut d'un bouton.
     * pour ouvrir une popup "confirm", et n'effectuer l'action que si l'utilisateur
     * a bien cliqué sur "ok".
     * @param string $message : le message à afficher dans la popup.
     * @return string : le code js à insérer dans le bouton.
     */
    public static function askConfirmation(string $message): string
    {
        return "onclick=\"return confirm('$message');\"";
    }

    /**
     * Cette méthode protège une chaine de caractères contre les attaques XSS.
     * De plus, elle transforme les retours à la ligne en balises <p> pour un affichage plus agréable. 
     * @param string $string : la chaine à protéger.
     * @return string : la chaine protégée.
     */
    public static function format(string $string): string
    {
        // Etape 1, on protège le texte avec htmlspecialchars.
        $finalString = htmlspecialchars($string, ENT_QUOTES);

        // Etape 2, le texte va être découpé par rapport aux retours à la ligne, 
        $lines = explode("\n", $finalString);

        // On reconstruit en mettant chaque ligne dans un paragraphe (et en sautant les lignes vides).
        $finalString = "";
        foreach ($lines as $line) {
            if (trim($line) != "") {
                $finalString .= "<p>$line</p>";
            }
        }

        return $finalString;
    }

    /**
     * Cette méthode permet de récupérer une variable de la superglobale $_REQUEST.
     * Si cette variable n'est pas définie, on retourne la valeur null (par défaut)
     * ou celle qui est passée en paramètre si elle existe.
     * @param string $variableName le nom de la variable à récupérer.
     * @param mixed $defaultValue la valeur par défaut si la variable n'est pas définie.
     * @return mixed la valeur de la variable ou la valeur par défaut.
     */
    public static function request(string $variableName, mixed $defaultValue = null): mixed
    {
        return $_REQUEST[$variableName] ?? $defaultValue;
    }
    /**
     * Convertit une chaîne de caractères en slug URL-friendly.
     * Transforme le texte en minuscules, supprime les accents, remplace les caractères 
     * spéciaux par des tirets et nettoie les tirets superflus.
     * @param string $text le texte à convertir.
     * @return string le slug généré.
     */
    public static function slugify(string $text): string
    {
        // Convertit en minuscules
        $text = strtolower($text);

        // Remplace les accents
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);

        // Remplace tout ce qui n’est pas alphanumérique par un tiret
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);

        // Enlève les tirets multiples
        $text = preg_replace('/-+/', '-', $text);

        // Supprime les tirets au début et à la fin
        return trim($text, '-');
    }

    public static function getUserPictureUrl(?string $filename): string
    {
        $baseUrl = "./public";

        if (empty($filename)) {
            return htmlspecialchars($baseUrl . "/img/avatar.webp");
        }

        return htmlspecialchars($baseUrl . "/upload/users/" . $filename);
    }

    public static function getBookPictureUrl(?string $filename): string
    {
        $baseUrl = "./public";

        if (empty($filename)) {
            return htmlspecialchars($baseUrl . "/img/coeur.svg");
        }

        return htmlspecialchars($baseUrl . "/upload/books/" . $filename);
    }

    public static function generateNewFilename(mixed $fileInfo, ?string $default = null): ?string
    {
        if (empty($fileInfo) || $fileInfo["error"] !== UPLOAD_ERR_OK) {
            return $default;
        }

        $extension = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);

        // Nouveau nom unique
        return uniqid('img_', true) . '.' . $extension;
    }

    public static function savePicture(mixed $fileInfo, string $filename, string $path): ?string
    {
        if (empty($fileInfo) || $fileInfo["error"] !== UPLOAD_ERR_OK || empty($filename) || empty($path)) {
            return null;
        }

        if (!in_array($path, ["users", "books"])) {
            return null;
        }

        $tmpName = $fileInfo['tmp_name'];
        $projectRoot = dirname($_SERVER['SCRIPT_FILENAME']);

        // Dossier de destination
        $destination = "$projectRoot/public/upload/$path/$filename";

        move_uploaded_file($tmpName, $destination);

        return $destination;
    }

    public static function deletePicture(string $filename, string $path): void
    {
        if (empty($filename)) {
            return;
        }

        $projectRoot = dirname($_SERVER['SCRIPT_FILENAME']);
        $destination = "$projectRoot/public/upload/$path/$filename";

        if (file_exists($destination)) {
            unlink($destination);
        }
    }

    /**
     * Retourne une chaîne compacte pour une date (format "messenger-like") :
     * - Même jour  => "HH:mm"
     * - Même semaine (ISO week) mais pas même jour => jour abrégé (fr) ex: "sam."
     * - Même année mais pas même semaine => "DD.MM"
     * - Autre année => "DD.MM.YYYY"
     *
     * @param DateTime $date
     * @return string
     */
    public static function formatCompactDate(DateTime $date): string
    {
        if (empty($date)) {
            return "";
        }

        $tz = new DateTimeZone('Europe/Paris');
        $date->setTimezone($tz);

        $now = new DateTime('now', $tz);

        // même jour
        if ($date->format('Y-m-d') === $now->format('Y-m-d')) {
            return $date->format('H:i');
        }

        // même semaine (ISO week number + ISO week-year)
        if ($date->format('W') === $now->format('W') && $date->format('o') === $now->format('o')) {
            $days = [
                1 => 'lun.',
                2 => 'mar.',
                3 => 'mer.',
                4 => 'jeu.',
                5 => 'ven.',
                6 => 'sam.',
                7 => 'dim.'
            ];
            $dow = (int) $date->format('N');
            return $days[$dow] ?? $date->format('D');
        }

        // même année
        if ($date->format('Y') === $now->format('Y')) {
            return $date->format('d.m');
        }

        // année différente
        return $date->format('d.m.Y');
    }

    /**
     * Retourne une chaîne compacte avec date et heure :
     * - même année => "dd.mm H:i"
     * - autre année => "dd.mm.Y H:i"
     *
     * @param DateTime $date
     * @return string
     */
    public static function formatMessageDateTime(DateTime $date): string
    {
        if (empty($date)) {
            return "";
        }

        $tz = new DateTimeZone('Europe/Paris');
        $date->setTimezone($tz);

        $now = new DateTime('now', $tz);

        if ($date->format('Y') === $now->format('Y')) {
            return $date->format('d.m H:i');
        }

        return $date->format('d.m.Y H:i');
    }
}
