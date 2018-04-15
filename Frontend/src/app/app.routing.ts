import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuard } from './_guards/index';

import { LoginComponent } from './login/login.component';
import { StandardComponent } from './standard/standard.component';
import { AdminComponent } from './admin/admin.component';
import { UserComponent } from './user/user.component';
import { SensorComponent } from './sensor/sensor.component';
import { PlantComponent } from './plant/plant.component';
import { ErrorComponent } from './error/error.component';
import { StatsComponent } from './stats/stats.component';

export const routes: Routes = [
    
    {
        path: '',
        redirectTo: 'login',
        pathMatch: 'full',
    },
    {
        path: 'login',
        component: LoginComponent
    },
    {
        path: 'dashboard',
        component: StandardComponent,
        canActivate: [AuthGuard],
        children: [
            {
                path: 'stats',
                component: StatsComponent
            },
            {
                path: 'stats2',
                component: StatsComponent
            }
        ]
    },
    {
        path: 'controlpanel',
        component: AdminComponent,
        //canActivate: [AuthGuard],
        children: [
            {
                path: 'user',
                component: UserComponent
            },
            {
                path: 'plant',
                component: PlantComponent
            },
            {
                path: 'sensor',
                component: SensorComponent
            }
        ]
    },
    {
        path: 'error',
        component: ErrorComponent
    },
    {
        path: '**',
        redirectTo: 'login'
    }

];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule { }