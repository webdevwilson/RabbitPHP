<?
class ArticlesBootstrap extends Bootstrap{
    
    protected function bootstrap(){
        $author             = $this->manager->create_author();
        $author->name       = 'Matt Parker';
        $this->manager->commit($author);

        $tag                = $this->manager->create_tag();
        $tag->label         = 'Test Tag';
        $this->manager->commit($tag);

        $article            = $this->manager->create_article();
        $article->title     = 'Example Article';
        $article->body      = 'Articles are awesome, aren\'t they?';
        $article->author    = $author;
        $article->tags      = array($tag);
        $this->manager->commit($article);
    }

}
?>
