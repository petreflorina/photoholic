/** angular */
import {Component, OnInit, Input} from '@angular/core';
import {QuestionComment} from '../../Resources/questions/questions';
import {CommentService} from '../../CommentCenter/services/comment.service';
import {Http} from "@angular/http";

@Component({
    selector: 'list-comments',
    templateUrl: '/app/Photoholic/Resources/directives/comments.template.html',
    providers: [CommentService]
})

export class CommentsDirectiveComponent implements OnInit {
    @Input() subjectId:number;
    @Input() parentEntity:any;
    entity:any;
    formObject: QuestionComment<any>;
    private serverMessage:string;
    private user:string;
    private hideServerMessage:boolean = true;

    constructor(private CommentService: CommentService,
                private http:Http) {
        this.instance();
    }

    ngOnInit() {
        this.getMany();

        this.http.get('api/current-user')
            .map(res => <any> res.json())
            .subscribe(res => {
                this.user = res['data'];
            });

    }

    instance() {
        this.formObject = new QuestionComment();
    }

    getMany() {
        this.CommentService.getMany(this.subjectId).subscribe(
            res => {
                this.entity = res['data'];
            }
        );
    }

    onSubmit(formObject: any) {
        if (!this.formObject.content) {
            alert('The comment should not be empty');
            return false;
        }
        this.formObject.picture = this.entity.id;
        this.CommentService.submit(formObject).subscribe(
            res => {
                this.entity['comments'].unshift(res['data']);
                this.serverMessage = 'Comment created with success!';
                this.handleServerMessage();
            }
        );
        this.instance();
    }

    onDelete(commentId: number, i: number) {
        this.CommentService.onDelete(commentId).subscribe(
            res => {
                this.entity['comments'].splice(i, 1);
                this.serverMessage = res['data'];
                this.handleServerMessage();
            }
        );
    }

    handleServerMessage() {
        if (this.serverMessage) {
            setTimeout(() => this.hideServerMessage = false, 2000)
        }
        this.hideServerMessage = true;
    }
}