import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import {TagService} from '../services/tag.service';
@Component({
    templateUrl: '/app/Photoholic/TagCenter/templates/tags.template.html',
    providers: [TagService]
})

export class TagsComponent implements OnInit {
    entities: any;

    constructor(private TagService: TagService,
                private router: Router) {
    }

    ngOnInit() {
        this.getMany();
    }

    getMany() {
        this.TagService.getManyTags().subscribe(
            res => {
                this.entities = res['data'];
            }
        );
    }
}

