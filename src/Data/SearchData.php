<?php

namespace App\Data;

/**
 * Class for the data of search posts
 */
class SearchData
{
    /**
     * The content of the query for title posts
     *
     * @var string|null
     */
    private ?string $query = '';

    /**
     * Array of tag for search posts
     *
     * @var array|null
     */
    private ?array $categories = [];

    /**
     * Array of user for the search posts
     *
     * @var array|null
     */
    private ?array $author = [];



    /**
     * Get the content of the query for title posts
     *
     * @return  string|null
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set the content of the query for title posts
     *
     * @param  string|null  $query  The content of the query for title posts
     *
     * @return  self
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get array of tag for search posts
     *
     * @return  array|null
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set array of tag for search posts
     *
     * @param  array|null  $categories  Array of tag for search posts
     *
     * @return  self
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get array of user for the search posts
     *
     * @return  array|null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set array of user for the search posts
     *
     * @param  array|null  $author  Array of user for the search posts
     *
     * @return  self
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }
}