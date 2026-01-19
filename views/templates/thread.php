<?php
function isSelected(ThreadItemModel $item): string
{
    return $item->getIdThread() == Utils::request('id') ? "selected" : "";
}
?>



<section id="thread-list">
    <div class="thread-header">
        <h3>Messagerie</h3>
    </div>
    <ul id="threads-container">
        <?php if (!empty($threads)): ?>
            <?php foreach ($threads as $thread): ?>
                <li class="thread-item <?= isSelected($thread) ?>">
                    <a href="?action=showthreads&id=<?= $thread->getIdThread() ?>">
                        <div class="avatar">
                            <div class="rounded-full">
                                <img src="<?= Utils::getUserPictureUrl($thread->getUserPicture()) ?>"
                                    alt="<?= $thread->getUsername() ?>" />
                            </div>
                        </div>
                        <div class="preview">
                            <span class="username" aria-label="Nom d'utilisateur">
                                <?= $thread->getUsername() ?>
                            </span>
                            <span class="date-last-message" aria-label="Date dernier message">
                                <?= Utils::formatCompactDate($thread->getDateLastMessage()) ?>
                            </span>
                            <span class="last-message" aria-label="Dernier message">
                                <?= $thread->getPreviewLastMessage() ?>
                            </span>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li id="no-message">
                Aucun message pour le moment
            </li>
        <?php endif; ?>
    </ul>
</section>
<section id="message-preview">
    <?php if (!empty($current)): ?>
        <div class="user-info">
            <div class="avatar">
                <div class="rounded-full">
                    <img src="<?= Utils::getUserPictureUrl($current->getUserPicture()) ?>"
                        alt="<?= $current->getUsername() ?>" />
                </div>
            </div>
            <span>
                <?= $current->getUsername() ?>
            </span>
        </div>
        <div class="messages-list">

        </div>
    <?php endif; ?>
</section>