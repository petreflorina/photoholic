import {Component, TemplateRef} from '@angular/core';
import {Http} from '@angular/http';
import {TagService} from "./Photoholic/TagCenter/services/tag.service";

@Component({
    selector: 'photoholic',
    templateUrl: '/app/Photoholic.template.html',
    providers: [TemplateRef, TagService]
})

export class Photoholic {
    private user:any;
    private tags:any;

    constructor(private http:Http,
                private TagService:TagService) {
    }

    ngOnInit() {

        this.getManyTags();

        this.http.get('api/current-user')
            .map(res => <any> res.json())
            .subscribe(res => {
                this.user = res['data'];
            });
    }

    getManyTags(){
            this.TagService.getManyTags().subscribe(
                res => {
                    this.tags = res['data']
                }
            );
    }
}