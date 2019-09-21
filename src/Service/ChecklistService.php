<?php
// src/Service/MessageGenerator.php
namespace App\Service;

/**
 * Serice used to analyce the keyword content of a given string.
 */
class ChecklistService
{
    /**
     * Keywords to be searched in the content.
     */
    private $keywords;

    /**
     * Minimum nomber of words a content must have.
     */
    private $min_number_of_words;

    /**
     * Constructor.
     *
     * @param $keywords {String[]} Keywords to be searched in the content. 
     * @param $min_number_of_words {Number} Minimum nomber of words a content must have.
     */
    public function __construct($keywords, $min_number_of_words)
   {
       $this->keywords = array_map('strtolower', $keywords);
       $this->min_number_of_words = $min_number_of_words;
   }

   /**
    * Analizes the given content.
    *
    * @param $content {String} The content to analyze.
    * @return If the content has less words than the configured minimum number, it returns false.
    * Otherwise it returs an array with the content itself, the number of keywords used in the content,
    * and the denisty of the words: the keywords used divided by the number of words.
    */
    public function analize($content)
    {
        $number_of_words = sizeof(explode(" ", $content));

        if ($number_of_words < $this->min_number_of_words) {
            return false;
        }

        $lower_content = strtolower($content);
        $keywords_used = 0;
        foreach ($this->keywords as $keyword) {
            if (strpos($lower_content, $keyword) !== false) {
                $keywords_used++;
            }
        }
        $density = $keywords_used / $number_of_words;

        return [
            "content" => $content,
            "keywords used" => $keywords_used,
            "average keywords density" => $density
        ];
    }

    /**
     * Returns the minimum number of words.
     * @return The minimum number of words.
     */
    public function getMinNumberOfWords()
    {
        return $this->min_number_of_words;
    }

    /**
     * Returns the keywords.
     * @return The keywords.
     */
    public function getKeywords() {
        return $this->keywords;
    }
}