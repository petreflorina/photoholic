import { ModuleWithProviders }   from '@angular/core';
import { Routes, RouterModule }  from '@angular/router';

import {PictureCenterComponent} from './PictureCenter.component';
import {PictureComponent} from './components/picture.component';
import {PictureFormComponent} from './components/pictureForm.component';

const pictureCenterRoutes: Routes = [
    { path: 'v-2/picture/form', component: PictureFormComponent },
    {
        path: 'v-2/picture',
        component: PictureCenterComponent,
        children: [
            {
                path: ':id',
                component: PictureComponent
            },
            {
                path: ':id/form',
                component: PictureFormComponent
            }
        ]
    }
];

export const pictureCenterRouting: ModuleWithProviders = RouterModule.forChild(pictureCenterRoutes);