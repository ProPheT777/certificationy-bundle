<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\Twig\Extension;

use Certificationy\Component\Certy\Model\Answer;
use Certificationy\Component\Certy\Model\Question;

class CertificationExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    protected $cache;

    /**
     *
     */
    public function __construct()
    {
        $this->cache = array();
    }
    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'is_valid' => new \Twig_SimpleFunction('is_valid', array($this, 'isValid'))
        );
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
          'class' => new \Twig_SimpleFilter('class', array($this, 'getAnswerClass'))
        );
    }

    /**
     * @param Answer $answer
     */
    public function getAnswerClass(Answer $answer)
    {
        if ($answer->isAnswered()) {
            if (!$answer->isValid()) {
                return 'alert-danger';
            }
        }

        if ($answer->isValid()) {
            return 'alert-success';
        }
    }

    /**
     * @param Question $question
     */
    public function isValid(Question $question)
    {
        $oid = spl_object_hash($question);

        if (!isset($this->cache[$oid])) {
            $this->cache[$oid] = $question->isValid();
        }

        return $this->cache[$oid];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'certy.certification_extension';
    }
}
