import {ModuleWithProviders}   from '@angular/core';
import {Routes, RouterModule}  from '@angular/router';

import {TagCenterComponent} from './TagCenter.component';
import {TagComponent} from './components/tag.component';
import {TagFormComponent} from './components/tagForm.component';
import {TagsComponent} from './components/tags.component';

const tagCenterRoutes: Routes = [
    { path: 'v-2/tags', component: TagsComponent},
    { path: 'v-2/tag/form', component: TagFormComponent},
    {
        path: 'v-2/tag',
        component: TagCenterComponent,
        children: [
            {
                path: ':id',
                component: TagComponent
            }
        ]
    }
];

export const tagCenterRouting: ModuleWithProviders = RouterModule.forChild(tagCenterRoutes);