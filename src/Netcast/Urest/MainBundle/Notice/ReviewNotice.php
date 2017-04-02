<?php

    namespace Netcast\Urest\MainBundle\Notice;

class ReviewNotice extends BaseNotice
{
    /**
     * get new review
     * @return array
     */
    public function getNewReview()
    {
        $reviewRepository = $this->em->getRepository('Netcast\Urest\MainBundle\Entity\Review');
        $newReviews = $reviewRepository->findBy(['lang' => $this->getCurrentLocale(), 'new' => true],['created' => 'DESC']);

        return $newReviews;

    }
}