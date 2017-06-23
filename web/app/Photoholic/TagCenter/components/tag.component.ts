import {Component, OnInit} from '@angular/core';
import {TagService} from '../services/tag.service';
import {Subscription} from 'rxjs';
import {ActivatedRoute, Router} from '@angular/router';

@Component({
    templateUrl: '/app/Photoholic/TagCenter/templates/tag.template.html',
    providers: [TagService],
    directives: []
})

export class TagComponent implements OnInit{
    entity: any;
    private sub: Subscription;
    private id: number;

    constructor(private route: ActivatedRoute,
                private TagService: TagService,
                private router: Router) {
    }

    ngOnInit() {
        this.sub = this.route.params.subscribe(params => {
            this.id = +params['id']; // (+) converts string 'id' to a number
            this.getOne();
        });
    }

    getOne() {
        this.TagService.getOne(this.id).subscribe(
            res => {
                this.entity = res['data'];
            }
        );
    }
}


