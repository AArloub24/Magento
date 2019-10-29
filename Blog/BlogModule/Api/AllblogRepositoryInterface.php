<?php
namespace Blog\BlogModule\Api;

interface AllblogRepositoryInterface
{
	public function save(\Blog\BlogModule\Api\Data\AllblogInterface $blog);

    public function getById($blogId);

    public function delete(\Blog\BlogModule\Api\Data\AllblogInterface $blog);

    public function deleteById($blogId);
}
