/** angular */
import {Component, OnInit, Input} from '@angular/core';
import {UserService} from '../../UserCenter/services/user.service';
import {PictureService} from '../../PictureCenter/services/picture.service';

@Component({
    selector: 'list-user-pictures',
    templateUrl: '/app/Photoholic/Resources/Directives/userPictures.template.html',
    providers: [UserService, PictureService]
})

export class UserPicturesDirectiveComponent implements OnInit {
    @Input() subjectId: number;
    @Input() parentEntity: any;
    private serverMessage: any;

    entities: any;

    constructor(private UserService: UserService,
                private PictureService: PictureService) {
    }

    ngOnInit() {
        this.getMany();
    }

    getMany() {
        this.UserService.getManyPicturesForUser(this.subjectId, 0, 50).subscribe(
            res => {
                this.entities = res['data'];
            }
        );
    }

    onDelete(pictureId: number, i: number) {
        this.PictureService.onDelete(pictureId).subscribe(
            res => {
                this.entities.splice(i, 1);
                this.serverMessage = res['data'];
                if (this.parentEntity.numberOfPictures >= 2) {
                    setTimeout(() => this.serverMessage = null, 5000);
                }
                this.parentEntity.numberOfPictures--;
            }
        );
    }
}