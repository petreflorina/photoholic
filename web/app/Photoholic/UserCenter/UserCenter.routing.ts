import { ModuleWithProviders }  from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import {UserComponent} from './components/user.component';
import {UserCenterComponent} from './UserCenter.component';
import {UserFormComponent} from './components/userForm.component';

const userCenterRoutes: Routes = [
    { path: 'v-2/user/form', component: UserFormComponent },
    {
        path: 'v-2/user',
        component: UserCenterComponent,
        children: [
            {
                path: ':id',
                component: UserComponent
            },
            {
                path: ':id/form',
                component: UserFormComponent
            }
        ]
    }
];

export const userCenterRouting: ModuleWithProviders = RouterModule.forChild(userCenterRoutes);