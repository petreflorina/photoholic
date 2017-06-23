/** angular */
import {Component, OnInit, Input} from '@angular/core';
import {UserService} from "../../UserCenter/services/user.service";
import {PictureService} from "../../PictureCenter/services/picture.service";

@Component({
    selector: 'picture-upload',
    templateUrl: '/app/Photoholic/Resources/directives/pictureUpload.template.html',
    providers: [UserService, PictureService]
})

export class PictureUploadDirectiveComponent implements OnInit {
    @Input() subjectId: number;

    entities: any;

    constructor(private UserService: UserService,
                private PictureService: PictureService) {
    }

    ngOnInit() {
    }
}