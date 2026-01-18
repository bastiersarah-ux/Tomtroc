-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 18 jan. 2026 à 09:02
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tomtroc`
--

-- --------------------------------------------------------

--
-- Structure de la table `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `status` enum('disponible','non dispo.') NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `book`
--

INSERT INTO `book` (`id`, `title`, `author`, `description`, `status`, `date_creation`, `id_user`, `picture`) VALUES
(1, 'Esther', 'Alabaster', 'Esther est une réinterprétation moderne et artistique d’un récit ancien, présentée dans l’esthétique raffinée d’Alabaster. À travers une mise en page aérienne et des photographies délicatement composées, le livre invite le lecteur à redécouvrir un parcours profond de courage, de vulnérabilité et de détermination. Chaque chapitre mêle réflexion spirituelle, analyse contemporaine et contemplation visuelle, créant une expérience de lecture immersive et introspective. Plus qu’un simple livre, Esther devient un objet méditatif, pensé pour inspirer le calme, la foi en soi et la beauté qui se cache dans les décisions difficiles de la vie.', 'disponible', '2026-01-13 15:56:01', 4, 'esther.jpg'),
(2, 'The Kinfolk Table', 'Nathan Williams', 'J\'ai récemment plongé dans les pages de \'The Kinfolk Table\' et j\'ai été enchanté par cette œuvre captivante. Ce livre va bien au-delà d\'une simple collection de recettes ; il célèbre l\'art de partager des moments authentiques autour de la table. \r\n\r\nLes photographies magnifiques et le ton chaleureux captivent dès le départ, transportant le lecteur dans un voyage à travers des recettes et des histoires qui mettent en avant la beauté de la simplicité et de la convivialité. \r\n\r\nChaque page est une invitation à ralentir, à savourer et à créer des souvenirs durables avec les êtres chers. \r\n\r\n\'The Kinfolk Table\' incarne parfaitement l\'esprit de la cuisine et de la camaraderie, et il est certain que ce livre trouvera une place spéciale dans le cœur de tout amoureux de la cuisine et des rencontres inspirantes.', 'disponible', '2026-01-13 15:59:04', 5, 'thekinfolktable.jpg'),
(3, 'Wabi Sabi', 'Beth Kempton', 'Wabi Sabi propose une plongée fascinante dans la philosophie japonaise de l’imperfection, de la simplicité et du caractère transitoire de chaque chose. \r\n\r\nBeth Kempton guide le lecteur dans une quête douce et apaisante : apprendre à accueillir les changements, à lâcher prise sur ce qui ne peut être contrôlé et à trouver la beauté dans les instants les plus discrets du quotidien.\r\n \r\nÀ mi-chemin entre développement personnel, spiritualité et carnet de voyage, l’ouvrage mélange anecdotes, enseignements ancestraux et exercices pratiques pour aider à vivre plus sereinement. Une invitation à ralentir, à contempler et à savourer l’élégance de l’incomplet.', 'disponible', '2026-01-13 16:01:36', 5, 'wabisabi.jpg'),
(4, 'Milk & honey', 'Rupi Kaur', 'Milk & Honey rassemble des poèmes qui explorent l’amour, la douleur, la guérison et la renaissance. \r\n\r\nAvec une écriture brute, épurée et profondément émotionnelle, Rupi Kaur met en lumière des expériences intimes et universelles. Chaque page est une confession, un murmure ou un cri, accompagné de dessins minimalistes qui renforcent la puissance du texte. \r\n\r\nLe recueil offre un chemin en quatre temps — la souffrance, l’amour, la rupture et le réapprentissage de soi — créant un parcours poétique complet. C’est un livre que l’on lit d’une traite ou que l’on savoure lentement, un compagnon lumineux dans les périodes de transformation.', 'disponible', '2026-01-13 16:02:41', 6, 'milkandhoney.jpg'),
(5, 'Delight!', 'Justin Rossow', 'Delight est un hommage vibrant aux petites joies du quotidien, celles que l’on remarque trop rarement mais qui transforment nos journées. Justin Rossow invite le lecteur à ralentir, observer et nourrir une attitude de gratitude profonde. \r\n\r\nÀ travers des textes inspirants, des anecdotes bienveillantes et un design audacieux, l’ouvrage démontre que la beauté se trouve souvent dans le simple, l’inattendu ou le micro-moment. \r\n\r\nCe livre coloré, optimiste et résolument positif devient un guide pratique pour cultiver l’émerveillement, réenchanter sa routine et adopter un regard plus doux sur le monde.', 'non dispo.', '2026-01-13 16:03:50', 9, 'delight.jpg'),
(6, 'Milwaukee Mission', 'Elder Cooper Low', 'Dans Milwaukee Mission, Elier Cooper Lowe propose un voyage photographique intense et réaliste au cœur d’une ville américaine en pleine transition. \r\n\r\nÀ travers des portraits humains, des paysages urbains bruts et des instantanés de vie locale, le livre met en lumière les forces, les fragilités et l’identité profonde de Milwaukee. \r\n\r\nChaque image raconte une histoire : celle d’un quartier qui change, d’une communauté qui résiste ou d’individus qui réinventent leur avenir. Cet ouvrage se présente à la fois comme une archive visuelle, un témoignage social et une exploration intime d’un territoire méconnu. Un livre puissant et engagé.', 'disponible', '2026-01-13 16:04:47', 8, 'milwaukeemission.jpg'),
(7, 'Minimalist Graphics', 'Julia Schonlau', 'Minimalist Graphics est un guide inspirant pour les amoureux du design épuré et intentionnel. Julia Schmidt y explore les principes fondamentaux du minimalisme visuel : équilibre, espace négatif, typographie raffinée, harmonie des formes et limitation volontaire des éléments. \r\n\r\nÀ travers des exemples concrets, des analyses détaillées et des compositions modernes, le livre aide les créatifs à comprendre comment simplifier sans appauvrir, et comment donner plus de force au message en réduisant le superflu. \r\n\r\nC’est un outil précieux pour les designers graphiques, les étudiants en communication visuelle ou toute personne sensible à la beauté de l’essentiel.', 'disponible', '2026-01-13 16:05:40', 7, 'minimalistgraphics.jpg'),
(8, 'Hygge', 'Meik Wiking', 'Dans Hygge, Meik Wiking dévoile les secrets de l’art de vivre danois, reconnu comme l’un des plus heureux au monde. \r\n\r\nIl explore comment créer une atmosphère chaleureuse, réconfortante et authentique, que ce soit à travers la décoration, les moments de convivialité, la lumière, la nourriture ou la connexion humaine. Le livre mêle conseils pratiques, recettes, anecdotes culturelles et résultats d’études menées par l’Institut du bonheur. \r\n\r\nC’est une invitation à ralentir, à savourer le présent et à transformer son intérieur en un refuge doux, sécurisant et profondément humain.', 'disponible', '2026-01-13 16:06:33', 6, 'hygge.jpg'),
(9, 'Innovation', 'Matt Ridley', 'Innovation propose une réflexion accessible mais rigoureuse sur les idées et inventions qui ont façonné le progrès humain. Matt Ridley y analyse les mécanismes qui stimulent la créativité, les conditions qui encouragent l’innovation et les freins qui la ralentissent. \r\n\r\nEn revisitant l’histoire de découvertes majeures — parfois accidentelles — il explique comment les sociétés évoluent lorsque l’audace s’accompagne de persévérance et de collaboration. \r\n\r\nCe livre stimulant montre que l’innovation n’est ni un miracle ni un hasard rare, mais un processus vivant qui se nourrit de liberté, d’expérimentation et de curiosité. Une lecture inspirante pour les entrepreneurs et les esprits créatifs.', 'disponible', '2026-01-13 16:07:34', 10, 'innovation.jpg'),
(10, 'Psalms', 'Alabaster', 'Dans cette édition artistique des Psaumes, Alabaster propose une fusion délicate entre photographie contemporaine, poésie biblique et design minimaliste. Le texte ancien, reconnu pour sa profondeur spirituelle, est mis en valeur par des visuels lumineux et une mise en page qui respire. \r\n\r\nLe livre devient ainsi une expérience méditative, invitant à la contemplation, à la prière ou tout simplement à la réflexion intérieure. \r\n\r\nChaque page semble suspendue dans le temps et encourage un rapport intime à la nature, à la foi et à la vulnérabilité humaine. Un ouvrage idéal pour ceux qui cherchent beauté et apaisement.', 'disponible', '2026-01-13 16:08:27', 11, 'psalms.jpg'),
(11, 'Thinking, Fast & Slow', 'Daniel Kahneman', 'Dans ce classique moderne de la psychologie cognitive, Daniel Kahneman explore les deux systèmes qui gouvernent notre pensée : l’un rapide, intuitif et impulsif, l’autre plus lent, réfléchi et analytique. Thinking, Fast & Slow détaille comment nos décisions sont influencées par des biais, des illusions mentales et des automatismes souvent invisibles. \r\n\r\nAu fil des pages, l’auteur illustre ces mécanismes avec des expériences fascinantes, des études marquantes et des cas concrets du quotidien. \r\n\r\nCe livre dense mais passionnant change durablement la manière dont on perçoit son propre raisonnement et aide à prendre des décisions plus éclairées, tant dans la vie personnelle que professionnelle.', 'non dispo.', '2026-01-13 16:09:47', 12, 'thinkingfastandslow.jpg'),
(12, 'A Book Full Of Hope', 'Rupi Kaur', 'Ce livre est une déclaration d’amour à la résilience. Rupi Kaur y partage des poèmes lumineux, centrés sur la guérison, le réconfort et le renouveau après les tempêtes émotionnelles. \r\n\r\nAvec une écriture délicate et accessible, elle aborde les thèmes de l’acceptation, du pardon et de la redécouverte de soi. Ses mots, toujours accompagnés de dessins minimalistes, forment un cocon de douceur pour les lecteurs en quête d’apaisement. \r\n\r\nC’est un ouvrage qui se lit comme une main tendue, un rappel que même dans l’obscurité il existe une lumière intérieure à retrouver.', 'disponible', '2026-01-13 16:10:33', 16, 'abookfullofhope.jpg'),
(13, 'The Subtle Art Of Not Giving A Fuck', 'Mark Manson', 'Mark Manson livre ici un guide franc, provocateur et profondément lucide pour remettre en question nos priorités modernes. \r\n\r\nLoin des discours de développement personnel trop optimistes, il invite à accepter que la souffrance fait partie de la vie et que la clé du bonheur réside dans notre capacité à choisir soigneusement ce qui mérite notre énergie. \r\n\r\nÀ travers son humour décapant, ses anecdotes personnelles et ses réflexions honnêtes, il offre un appel à vivre plus fidèlement à soi-même, loin des injonctions sociales. Un ouvrage libérateur qui aide à se recentrer sur les valeurs essentielles.', 'disponible', '2026-01-13 16:11:46', 13, 'thesubtleartofnotgivingafuck.jpg'),
(14, 'Narnia', 'C.S Lewis', 'Narnia est un voyage enchanteur dans un monde où la magie règne, où les animaux parlent et où le courage d’un enfant peut changer le destin d’un royaume. \r\n\r\nC.S. Lewis y mêle imaginaire foisonnant, métaphores profondes et aventures palpitantes dans un récit devenu un classique de la littérature jeunesse. Chaque chapitre transporte le lecteur dans un univers riche, peuplé de créatures fantastiques, de batailles épiques et de symboles intemporels. \r\n\r\nCe livre est une invitation à rêver, à croire en l’extraordinaire et à redécouvrir la force de l’imagination.', 'non dispo.', '2026-01-13 16:12:38', 14, 'narnia.jpg'),
(15, 'Company Of One', 'Paul Jarvis', 'Dans Company of One, Paul Jarvis propose une vision alternative de l’entrepreneuriat moderne : plutôt que de grandir sans cesse, pourquoi ne pas créer une entreprise à taille humaine, centrée sur la liberté, la qualité et la satisfaction personnelle ? \r\n\r\nL’auteur partage des conseils pratiques, des exemples concrets et ses propres expériences pour montrer qu’une croissance volontairement limitée peut mener à plus de créativité, de flexibilité et de bonheur au travail. \r\n\r\nC’est un livre rafraîchissant et inspirant pour ceux qui rêvent d’indépendance et souhaitent construire un modèle professionnel durable.', 'disponible', '2026-01-13 16:13:20', 15, 'companyofone.jpg'),
(16, 'The Two Towers', 'J.R.R Tolkien', 'Deuxième tome du Seigneur des Anneaux, The Two Towers plonge le lecteur au cœur de la guerre qui oppose les forces du mal aux peuples libres de la Terre du Milieu. Frodo et Sam poursuivent leur mission dangereuse, tandis que leurs compagnons affrontent batailles, trahisons et révélations. \r\n\r\nTolkien y déploie toute la richesse de son univers : paysages grandioses, créatures mythiques, alliances inattendues et combats héroïques. \r\n\r\nL’intrigue gagne en intensité, les enjeux se renforcent, et chaque page captive par sa profondeur émotionnelle et sa puissance narrative. Un chef-d’œuvre d’aventure et de fantasy.', 'disponible', '2026-01-13 16:14:45', 17, 'thetwotowers.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `thread`
--

CREATE TABLE `thread` (
  `id` int(11) NOT NULL,
  `id_user1` int(11) NOT NULL,
  `id_user2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `thread_message`
--

CREATE TABLE `thread_message` (
  `id` int(11) NOT NULL,
  `id_thread` int(11) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT current_timestamp(),
  `content` longtext NOT NULL,
  `id_user_transmitter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `date_creation`, `profile_picture`, `slug`) VALUES
(1, 'j.doe', 'j.doe@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-05 10:10:48', NULL, 'j-doe'),
(4, 'CamilleClubLit', 'camille.c@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:31:18', NULL, 'camille-club-lit'),
(5, 'Alexlecture', 'alexl@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:33:22', NULL, 'alex-lecture'),
(6, 'Hugo1990_12', 'hugo1900@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:34:27', NULL, 'hugo1990_12'),
(7, 'Hamzalecture', 'Hamzalec@troctrom.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:35:21', NULL, 'hamza-lecture'),
(8, 'Christiane75014', 'christiane75@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:36:29', NULL, 'christiane75014'),
(9, 'Juju1432', 'juju14@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:37:21', NULL, 'juju1432'),
(10, 'Lou&Ben50', 'louben50@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:38:38', NULL, 'lou&ben50'),
(11, 'Lolobzh', 'lolobzh@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:39:39', NULL, 'lolobzh'),
(12, 'Sas634', 'sas@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:40:34', NULL, 'sas634'),
(13, 'Verogo33', 'vero@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:41:40', NULL, 'verogo33'),
(14, 'AnnikaBrahms', 'annikab@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:42:20', NULL, 'annikabrahms'),
(15, 'Victoirefabr912', 'victoiref@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:43:29', NULL, 'victoirefabr912'),
(16, 'ML95', 'ml@tromtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:44:48', NULL, 'ml95'),
(17, 'Lotrfanclub67', 'lotrfc@tomtroc.fr', '$2y$12$LMbmdMM0ErjJ6UY4CLdnWe0NDZlGPoQ/pT0LHi0O/kcYq6X1DcZ9O', '2026-01-13 15:45:31', NULL, 'lotrfanclub67');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `link_book_user` (`id_user`);

--
-- Index pour la table `thread`
--
ALTER TABLE `thread`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user1` (`id_user1`,`id_user2`),
  ADD KEY `link_thread_user_2` (`id_user2`);

--
-- Index pour la table `thread_message`
--
ALTER TABLE `thread_message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `link_thread_message_user` (`id_user_transmitter`),
  ADD KEY `link_thread_message_thread` (`id_thread`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `thread`
--
ALTER TABLE `thread`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `thread_message`
--
ALTER TABLE `thread_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `link_book_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `thread`
--
ALTER TABLE `thread`
  ADD CONSTRAINT `link_thread_user_1` FOREIGN KEY (`id_user1`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `link_thread_user_2` FOREIGN KEY (`id_user2`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `thread_message`
--
ALTER TABLE `thread_message`
  ADD CONSTRAINT `link_thread_message_thread` FOREIGN KEY (`id_thread`) REFERENCES `thread` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `link_thread_message_user` FOREIGN KEY (`id_user_transmitter`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
