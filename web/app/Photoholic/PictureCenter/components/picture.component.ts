import {Component} from '@angular/core';
import {PictureService} from '../services/picture.service';
import {Router, ActivatedRoute} from '@angular/router';
import {Subscription} from 'rxjs';
import {CommentsDirectiveComponent} from '../../Resources/directives/comments.component';
import {Http} from "@angular/http";

@Component({
    templateUrl: '/app/Photoholic/PictureCenter/templates/picture.template.html',
    providers: [PictureService],
    directives: [CommentsDirectiveComponent]
})

export class PictureComponent {
    entity:any;
    private sub:Subscription;
    private id:number;
    private user:string;
    private userId:number;

    constructor(private route: ActivatedRoute,
                private PictureService: PictureService,
                private router: Router,
                private http:Http) {
    }

    ngOnInit() {
        this.sub = this.route.params.subscribe(params => {
            this.id = +params['id']; // (+) converts string 'id' to a number
        });
        this.getOne();

        this.http.get('api/current-user')
            .map(res => <any> res.json())
            .subscribe(res => {
                this.user = res['data'];
            });
    }

    getOne() {
        this.PictureService.getOne(this.id).subscribe(
            res => {
                this.entity = res['data'];
                this.userId = this.entity.createdBy.id;
            }
        );
    }
}

