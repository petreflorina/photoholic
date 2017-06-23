import {Component} from '@angular/core';
import {UserService} from '../../UserCenter/services/user.service';
import {Subscription} from 'rxjs';
import {ActivatedRoute, Router} from '@angular/router';
import {UserPicturesDirectiveComponent} from '../../Resources/directives/userPictures.component';
import {Http} from '@angular/http';

@Component({
    templateUrl: '/app/Photoholic/UserCenter/templates/user.template.html',
    providers: [UserService],
    directives: [UserPicturesDirectiveComponent]
})

export class UserComponent {
    entity:any;
    private sub:Subscription;
    private id:number;
    user:string;

    constructor(private route: ActivatedRoute,
                private UserService: UserService,
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
        this.UserService.getOne(this.id).subscribe(
            res => {
                this.entity = res['data'];
            }
        );
    }
}


