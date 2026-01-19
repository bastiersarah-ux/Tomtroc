<?php

$hasId = !empty(Utils::request('id'));

function isSelected(ThreadItemModel $item): bool
{
	return $item->getIdThread() == Utils::request('id');
}

function isMessageOwner(ThreadMessageItemModel $item): bool
{
	return $item->getIdUserTransmitter() == Utils::getCurrentIdUser();
}
?>

<section id="thread-list" class="<?= $hasId ? "hide" : "" ?>">
	<div class=" thread-header">
		<h3>Messagerie</h3>
	</div>
	<ul id="threads-container">
		<?php if (!empty($threads)): ?>
			<?php foreach ($threads as $thread): ?>
				<li class="thread-item <?= isSelected($thread) ? "selected" : "" ?>">
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
<section id="message-preview" class="<?= !$hasId ? "hide" : "" ?>">
	<a class="btn btn-link btn-return md:hidden" href="?action=showthreads">
		<img src="./public/img/arrow-left.svg" />
		Retour
	</a>

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
			<?php foreach ($messages as $message): ?>
				<div class="message <?= isMessageOwner($message) ? "owner" : "" ?>">
					<div class="message-info">
						<?php if (!isMessageOwner($message)): ?>
							<div class="avatar">
								<div class="w-6 rounded-full">
									<img src="<?= Utils::getUserPictureUrl($message->getTransmitterPicture()) ?>"
										alt="<?= $message->getUsernameTransmitter() ?>" />
								</div>
							</div>
						<?php endif; ?>
						<span class="send-info">
							<?= Utils::formatMessageDateTime($message->getDateCreation()) ?>
						</span>
						<span class="loading loading-dots loading-xs ml-1 hidden"></span>
					</div>
					<div class="card">
						<div class="card-content">
							<?= $message->getContent() ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="message-prompt">
			<textarea id="message-input" data-limit-rows="true" rows="1" placeholder="Tapez votre message ici"
				class="textarea"></textarea>
			<button id="submit-message" class="tomtroc-button principal-green">Envoyer</button>
		</div>
	<?php endif; ?>
</section>

<script src="./public/thread.js"></script>