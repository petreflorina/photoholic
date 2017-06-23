import {NgModule}      from '@angular/core';
import {BrowserModule} from '@angular/platform-browser'
import {FormsModule, ReactiveFormsModule}    from '@angular/forms';

import {Photoholic} from '../Photoholic.component';
import {routing, photoholicRoutingProviders} from '../Photoholic.routing';
import {PictureCenterModule} from './PictureCenter/PictureCenter.module';
import {UserCenterModule} from './UserCenter/UserCenter.module';
import {HttpModule, JsonpModule} from '@angular/http';
import {TagCenterModule} from './TagCenter/TagCenter.module';

@NgModule({
    imports: [
        BrowserModule,
        FormsModule,
        ReactiveFormsModule,
        routing,
        UserCenterModule,
        PictureCenterModule,
        TagCenterModule,
        HttpModule,
        JsonpModule
    ],
    declarations: [Photoholic],
    bootstrap: [Photoholic],
    providers: [photoholicRoutingProviders]
})

export class PhotoholicModule {
}