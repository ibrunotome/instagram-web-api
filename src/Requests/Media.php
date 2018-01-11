<?php

namespace InstagramWeb\Requests;

class Media extends Instagram
{
    public function comment($mediaId, $text)
    {
        return $this->instagram->post("/web/comments/${mediaId}/add/", ['form_params' => ['comment_text' => $text]]);
    }

    public function deleteComment($mediaId, $commentId)
    {
        return $this->instagram->post("/web/comments/${mediaId}/delete/${commentId}/");
    }

    public function delete($mediaId)
    {
        return $this->instagram->post("/create/${mediaId}/delete/");
    }

    public function getByShortcode($shortcode)
    {
        return $this->instagram->get("/p/${shortcode}/?__a=1");
    }

    public function like($mediaId)
    {
        return $this->instagram->post("/web/likes/${mediaId}/like/");
    }

    public function unlike($mediaId)
    {
        return $this->instagram->post("/web/likes/${mediaId}/unlike/");
    }
}