import {Component, OnInit} from '@angular/core';

import {PictureService} from '../services/picture.service';
import {Router} from '@angular/router';
@Component({
    templateUrl: '/app/Photoholic/PictureCenter/templates/pictures.template.html',
    providers: [PictureService]
})

export class PicturesComponent implements OnInit {
    entities: any;

    constructor(private PictureService: PictureService,
                private router: Router) {
    }

    ngOnInit() {
        this.getMany();
    }

    getMany() {
        this.PictureService.getMany().subscribe(
            res => {
                this.entities = res['data'];
            }
        );
    }
}

