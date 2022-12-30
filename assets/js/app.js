
import '../css/app.scss';

import {Dropdown} from "bootstrap";
import {async} from "regenerator-runtime";
//Mon DOMContentLoaded se déclenche quand le document html initial a été complètement téléchargé et analysé par le navigateur.
document.addEventListener('DOMContentLoaded', () => {
    new App();
});

class App {
    constructor() {
        this.enableDropdowns();
        this.handleCommentForm()
    }
    enableDropdowns() {

        const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        dropdownElementList.map(function (dropdownToggleEl) {
            return new Dropdown(dropdownToggleEl)
        });

    }

    handleCommentForm() {

        const commentForm = document.querySelector('form.comment-form');

        if (null == commentForm) {
            return;
        }

        commentForm.addEventListener('submit', async (e) => {
            e.preventDefault();
           //Methode Fetch
            const response = await fetch('/ajax/comments', {
                method: 'POST',
                body: new FormData(e.target)
            });

            if (!response.ok) {
                return;
            }

            const json = await response.json();
            //Ici mes class .comment-count et .comment-list avec mon id #comment_content qui sont dans template>article>see.html.twig
            if (json.code == 'COMMENT_ADDED_SUCCESSFULLY') {
                const commentList = document.querySelector('.comment-list');
                const commentCount = document.querySelector('.comment-count');
                const commentContent = document.querySelector('#comment_content');
                // Mon CommentList je vais l'utiliser avec la function insertAdjacentHTML et je passe en message json //
                // qui corresponde à la vu de index.html.twig de comment (beforeend = on l'ajoute à la fin de la liste des commentaires)
                commentList.insertAdjacentHTML('beforeend', json.message);
                //Ici on va faire scroller l'utulisateur jusqu'a la fin de la liste des commentaires
                commentList.lastElementChild.scrollIntoView();
                //Ici on passe l'info de la cantité de commentaire que j'ai indiqué dans mon CommentController.php
                commentCount.innerText = json.numberOfComment;
                commentContent.value = '';
            }

        });
    }


}

