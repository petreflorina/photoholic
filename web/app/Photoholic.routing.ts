import {ModuleWithProviders} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {PicturesComponent} from './Photoholic/PictureCenter/components/pictures.component';

const pictureCenterRoutes: Routes = [
    {
        path: 'v-2/picture',
        loadChildren: 'app/Photoholic/PictureCenter/PictureCenter.module#PictureCenterModule'
    }
];

const userCenterRoutes: Routes = [
    {
        path: 'v-2/user',
        loadChildren: 'app/Photoholic/UserCenter/UserCenter.module#UserCenterModule'
    }
];

const tagCenterRoutes: Routes = [
    {
        path: 'v-2/tag',
        loadChildren: 'app/Photoholic/TagCenter/TagCenter.module#TagCenterModule'
    }
];

const appRoutes: Routes = [
    {path: 'v-2', component: PicturesComponent},
    ...pictureCenterRoutes,
    ...userCenterRoutes,
    ...tagCenterRoutes
];

export const photoholicRoutingProviders: any[] = [];

export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);