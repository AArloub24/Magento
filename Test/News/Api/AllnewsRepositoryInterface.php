<?php
namespace Test\News\Api;

interface AllnewsRepositoryInterface
{
	public function save(\Test\News\Api\Data\AllnewsInterface $news);

    public function getById($newsId);

    public function delete(\Test\News\Api\Data\AllnewsInterface $news);

    public function deleteById($newsId);
}
?>