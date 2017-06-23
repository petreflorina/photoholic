import {NgModule}       from '@angular/core';
import {FormsModule}    from '@angular/forms';
import {CommonModule}   from '@angular/common';
import {TagComponent} from './components/tag.component';
import {TagCenterComponent} from './TagCenter.component';
import {tagCenterRouting} from './TagCenter.routing';
import {TagFormComponent} from './components/tagForm.component';
import {TagsComponent} from './components/tags.component';

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        tagCenterRouting
    ],
    declarations: [
        TagCenterComponent,
        TagComponent,
        TagFormComponent,
        TagsComponent
    ],
    providers: []
})

export class TagCenterModule {
}