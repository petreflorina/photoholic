import {NgModule}       from '@angular/core';
import {CommonModule}   from '@angular/common';
import {FormsModule}    from '@angular/forms';

/* imports */
import {userCenterRouting} from './UserCenter.routing';

/* components */
import {UserComponent} from './components/user.component';
import {UserFormComponent} from './components/userForm.component';
import {UserCenterComponent} from './UserCenter.component';

@NgModule({
    imports: [
        CommonModule,
        FormsModule,
        userCenterRouting
    ],
    declarations: [
        UserCenterComponent,
        UserComponent,
        UserFormComponent
    ]
})

export class UserCenterModule {
}