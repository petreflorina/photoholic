import {NgModule}       from '@angular/core';
import {FormsModule}    from '@angular/forms';
import {CommonModule}   from '@angular/common';

import {PictureCenterComponent} from './PictureCenter.component';
import {pictureCenterRouting} from './PictureCenter.routing';
import {PictureComponent} from './components/picture.component';
import {PictureFormComponent} from './components/pictureForm.component';

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        pictureCenterRouting
    ],
    declarations: [
        PictureCenterComponent,
        PictureComponent,
        PictureFormComponent
    ],
    providers: []
})

export class PictureCenterModule {
}