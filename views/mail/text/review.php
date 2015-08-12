<?php

/*
 * This file is part of the mata project.
 *
 * (c) mata project <http://github.com/mata>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

?>
<?= Yii::t('user', 'Hello') ?>,

<?= Yii::t('user', 'This is review request from {0} for {1} <strong>{2}</strong>', [$authorName, $modelLabel, $label]) ?>.
<?= Yii::t('user', 'Please click the link below to review it.') ?>.

<?= $documentForReviewUrl ?>

<?= Yii::t('user', 'If you cannot click the link, please try pasting the text into your browser') ?>.
