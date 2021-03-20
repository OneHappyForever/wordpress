<?php

namespace SEOPress\Services;

if ( ! defined('ABSPATH')) {
    exit;
}

class ContextPage {
    protected $context = null;

    /**
     * @since 4.4.0
     *
     * @param int   $id
     * @param array $options
     *
     * @return void
     */
    public function buildContextWithCurrentId($id, $options = []) {
        $homeId = get_option('page_on_front');

        $this->buildContextDefault();

        $isPostType = get_post_type($id);

        if ($isPostType) {
            $this->setPostById((int) $id);
            $this->setIsSingle(true);
            $terms = get_the_terms($id, 'post_tag');

            if ( ! empty($terms)) {
                $this->setHasTag(true);
            }

            $categories = get_the_terms($id, 'category');
            if ( ! empty($categories)) {
                $this->setHasCategory(true);
            }

            $this->setIsPostType($isPostType, true);
        }

        if ($id === $homeId && null !== $homeId) {
            $this->setIsHome(true);
        }

        $term = term_exists($id);
        if (null !== $term) {
            $this->setIsCategory(true);
            $this->setTermId($id);
        }

        return $this;
    }

    /**
     * @since 4.4.0
     *
     * @return array
     */
    public function buildContextDefault() {
        global $post;

        $context = [
            'post'         => $post,
            'term_id'      => null,
            'is_single'    => false,
            'is_home'      => false,
            'is_product'   => false,
            'is_archive'   => false,
            'is_category'  => false,
            'is_author'    => false,
            'is_404'       => false,
            'has_category' => false,
            'has_tag'      => false,
            'paged'        => get_query_var('paged'),
        ];

        if (is_singular()) {
            $context = array_replace(['is_single' => true], $context);
        }
        if (is_home() || is_front_page()) {
            $context = array_replace(['is_home' => true], $context);
        }
        if (is_post_type_archive()) {
            $context = array_replace(['is_archive' => true], $context);
        }
        if (is_tax() || is_category() || is_tag()) {
            $context = array_replace(['is_category' => true], $context);
        }
        if (is_author()) {
            $context = array_replace(['is_author' => true], $context);
        }
        if (is_404()) {
            $context = array_replace(['is_404' => true], $context);
        }
        if (has_category()) {
            $context = array_replace(['has_category' => true], $context);
        }
        if (has_tag()) {
            $context = array_replace(['has_tag' => true], $context);
        }

        $this->context = $context;

        return $this;
    }

    /**
     * @since 4.4.0
     *
     * @return array
     */
    public function getContext() {
        if ($this->context) {
            return $this->context;
        }

        $this->buildContextDefault();

        return $this->context;
    }

    /**
     * @since 4.4.0
     *
     * @param string $key
     * @param bool   $value
     */
    protected function setContextBooleanByKey($key, $value) {
        $this->context[$key] = $value;

        return $this;
    }

    /**
     * @since 4.4.0
     *
     * @param string $value
     */
    public function setTermId($value) {
        $this->context['term_id'] = $value;

        return $this;
    }

    /**
     * @since 4.4.0
     *
     * @param string $value
     */
    public function setIsSingle($value) {
        $this->setContextBooleanByKey('is_single', $value);

        return $this;
    }

    /**
     * @since 4.4.0
     *
     * @param string $value
     */
    public function setHasTag($value) {
        $this->setContextBooleanByKey('has_tag', $value);

        return $this;
    }

    /**
     * @since 4.4.0
     *
     * @param string $value
     */
    public function setHasCategory($value) {
        $this->setContextBooleanByKey('has_category', $value);

        return $this;
    }

    /**
     * @since 4.4.0
     *
     * @param string $value
     */
    public function setIsHome($value) {
        $this->setContextBooleanByKey('is_home', $value);

        return $this;
    }

    /**
     * @since 4.4.0
     *
     * @param string $value
     */
    public function setIsCategory($value) {
        $this->setContextBooleanByKey('is_category', $value);

        return $this;
    }

    /**
     * @since 4.4.0
     *
     * @param int $id
     */
    public function setPostById($id) {
        $post                  = get_post($id);
        $this->context['post'] = $post;

        return $this;
    }

    /**
     * @since 4.4.0
     *
     * @param string $postType
     * @param int    $value
     */
    public function setIsPostType($postType, $value) {
        $this->setContextBooleanByKey(sprintf('is_%s', $postType), $value);

        return $this;
    }
}