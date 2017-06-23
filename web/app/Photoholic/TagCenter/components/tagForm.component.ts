import {Component, OnInit} from '@angular/core';
import {TagService} from '../services/tag.service';
import {Subscription} from 'rxjs';
import {ActivatedRoute, Router} from '@angular/router';
import {QuestionTag, QuestionUser} from "../../Resources/questions/questions";

@Component({
    templateUrl: '/app/Photoholic/TagCenter/templates/tagForm.template.html',
    providers: [TagService],
    directives: []
})

export class TagFormComponent implements OnInit{
    formObject: QuestionTag<any>;
    private sub: Subscription;
    private id: number;
    private ServerMessage: string;

    constructor(private route: ActivatedRoute,
                private TagService: TagService,
                private router: Router) {
    }

    ngOnInit() {
        this.sub = this.route.params.subscribe(params => {
            this.id = +params['id']; // (+) converts string 'id' to a number
        });

        this.formObject = new QuestionTag();
    }

    onSubmit(formObject: any) {
        this.TagService.submit(formObject).subscribe(
            res => {
                this.ServerMessage = res['data'];
            }
        );
    }
}


