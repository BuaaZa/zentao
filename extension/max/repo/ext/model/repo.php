<?php
/**
 * Get review.
 *
 * @param  int    $repoID
 * @param  string $entry
 * @param  string $revision
 * @access public
 * @return array
 */
public function getReview($repoID, $entry, $revision)
{
    return $this->loadExtension('repo')->getReview($repoID, $entry, $revision);
}

/**
 * Get bugs by repo.
 *
 * @param  int    $repoID
 * @param  string $browseType
 * @param  string $orderBy
 * @param  object $pager
 * @access public
 * @return array
 */
public function getBugsByRepo($repoID, $browseType, $orderBy, $pager)
{
    return $this->loadExtension('repo')->getBugsByRepo($repoID, $browseType, $orderBy, $pager);
}

/**
 * Save bug.
 *
 * @param  int    $repoID
 * @param  string $file
 * @param  int    $v1
 * @param  int    $v2
 * @access public
 * @return array
 */
public function saveBug($repoID, $file, $v1, $v2)
{
    return $this->loadExtension('repo')->saveBug($repoID, $file, $v1, $v2);
}

/**
 * Update bug.
 *
 * @param  int    $bugID
 * @param  string $title
 * @access public
 * @return string
 */
public function updateBug($bugID, $title)
{
    return $this->loadExtension('repo')->updateBug($bugID, $title);
}

/**
 * Update comment.
 *
 * @param  int    $commentID
 * @param  string $comment
 * @access public
 * @return string
 */
public function updateComment($commentID, $comment)
{
    return $this->loadExtension('repo')->updateComment($commentID, $comment);
}

/**
 * Delete comment.
 *
 * @param  int    $commentID
 * @access public
 * @return void
 */
public function deleteComment($commentID)
{
    return $this->loadExtension('repo')->deleteComment($commentID);
}

/**
 * Get last review info.
 *
 * @param  string $entry
 * @access public
 * @return object
 */
public function getLastReviewInfo($entry)
{
    return $this->loadExtension('repo')->getLastReviewInfo($entry);
}

/**
 * Get linked objects by comment.
 *
 * @param  string    $comment
 * @access public
 * @return array
 */
public function getLinkedObjects($comment)
{
    return $this->loadExtension('repo')->getLinkedObjects($comment);
}

/**
 * Get branches and tags.
 *
 * @param  int    $repoID
 * @param  string $oldRevision
 * @param  string $newRevision
 * @access public
 * @return object
 */
public function getBranchesAndTags($repoID, $oldRevision = '0', $newRevision = 'HEAD')
{
    return $this->loadExtension('repo')->getBranchesAndTags($repoID, $oldRevision, $newRevision);
}

/**
 * Get diff file tree.
 *
 * @param  string $diffs
 * @access public
 * @return object
 */
public function getDiffFileTree($diffs)
{
    return $this->loadExtension('repo')->getDiffFileTree($diffs);
}

/**
 * Build tree.
 *
 * @param  array  $files
 * @param  int    $parent
 * @access public
 * @return array
 */
public function buildTree($files = array(), $parent = 0)
{
    return $this->loadExtension('repo')->buildTree($files, $parent);
}

/**
 * Get front files.
 *
 * @param  array $nodes
 * @access public
 * @return string
 */
public function getFrontFiles($nodes)
{
    return $this->loadExtension('repo')->getFrontFiles($nodes);
}
