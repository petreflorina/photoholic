import {Component, OnInit} from '@angular/core';
import {ActivatedRoute, Router} from '@angular/router';
import {PictureService} from '../services/picture.service';
import {Subscription} from 'rxjs';
import {QuestionPicture} from '../../Resources/questions/questions';
import {PictureUploadDirectiveComponent} from '../../Resources/directives/pictureUpload.component';
import {Http} from '@angular/http';
import {TagService} from '../../TagCenter/services/tag.service';

@Component({
    templateUrl: '/app/Photoholic/PictureCenter/templates/pictureForm.template.html',
    providers: [PictureService, TagService],
    directives: [PictureUploadDirectiveComponent]
})

export class PictureFormComponent implements OnInit {
    formObject: QuestionPicture<any>;
    private sub:Subscription;
    private id:number;
    private method:any;
    private tags:any;
    private showFields:boolean = false;
    private serverMessage:string;
    private user:any;

    constructor(private route: ActivatedRoute,
                private PictureService: PictureService,
                private TagService: TagService,
                private router: Router,
                private http:Http) {
    }

    ngOnInit() {
        this.sub = this.route.params.subscribe(params => {
            this.id = +params['id']; // (+) converts string 'id' to a number
        });

        this.formObject = new QuestionPicture();

        this.getManyTags();

        this.http.get('api/current-user')
            .map(res => <any> res.json())
            .subscribe(res => {
                this.user = res['data'];
            });

        if (this.id) {
            this.method = 'put';
            this.showFields = true;
            this.PictureService.getOne(this.id, '/edit').subscribe(
                res => {
                    this.formObject = res['data'];
                }
            );
        } else {
            CustomJs.init();
        }
    }

    onSubmit(formObject: any) {
        this.PictureService.submit(formObject, this.method, this.id).subscribe(
            res => {
                this.serverMessage = res['data'];
            }
        );
    }

    getManyTags() {
        this.TagService.getManyTags().subscribe(
            res => {
                this.tags = res['data']
            }
        );
    }
}
