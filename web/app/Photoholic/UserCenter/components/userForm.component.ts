import {Component, OnInit} from '@angular/core';
import {QuestionUser} from '../../Resources/questions/questions';
import {UserService} from '../services/user.service';
import {Router, ActivatedRoute} from '@angular/router';
import {Subscription} from 'rxjs';

@Component({
    templateUrl: '/app/Photoholic/UserCenter/templates/userForm.template.html',
    providers: [UserService]
})

export class UserFormComponent implements OnInit {
    formObject: QuestionUser<any>;
    private sub: Subscription;
    private id: number;
    private method: any;
    private showFields: boolean = false;
    private ServerMessage: string;

    constructor(private route: ActivatedRoute,
                private UserService: UserService,
                private router: Router) {
    }

    ngOnInit() {
        this.sub = this.route.params.subscribe(params => {
            this.id = +params['id']; // (+) converts string 'id' to a number
        });

        this.formObject = new QuestionUser();

        if (this.id) {
            this.method = 'put';
            this.showFields = true;
            this.UserService.getOne(this.id, '/edit').subscribe(
                res => {
                    this.formObject = res['data'];
                }
            );
        }
    }

    onSubmit(formObject: any) {
        this.UserService.submit(formObject, this.method, this.id).subscribe(
            res => {
                this.ServerMessage = res['data'];
            }
        );
    }
}