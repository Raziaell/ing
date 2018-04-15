import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { RouterModule } from '@angular/router';
import { HttpModule } from '@angular/http';

import { ChartsModule } from 'ng2-charts';
import { Ng2TableModule } from 'ng2-table'; 
import { Ng2SmartTableModule } from 'ng2-smart-table';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';

import { AppComponent } from './app.component';
import { UserService, ApiService, EnvService } from './_services';
import { AuthGuard } from './_guards';

import { AppRoutingModule } from './app.routing';
import { StandardComponent } from './standard/standard.component';
import { AdminComponent } from './admin/admin.component';
import { LoginComponent } from './login/login.component';
import { UserComponent } from './user/user.component';
import { SensorComponent } from './sensor/sensor.component';
import { PlantComponent } from './plant/plant.component';

import { SharedDataService } from './_services/shared_data.service';
import { ErrorComponent } from './error/error.component';
import { StatsComponent } from './stats/stats.component';



@NgModule({
  declarations: [
    AppComponent,
    StandardComponent,
    AdminComponent,
    LoginComponent,
    UserComponent,
    SensorComponent,
    PlantComponent,
    ErrorComponent,
    StatsComponent,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    RouterModule,
    HttpModule,
    AppRoutingModule,
    ChartsModule,
    Ng2TableModule,
    Ng2SmartTableModule,
    NgbModule.forRoot()
  ],
  providers: [ 
    AuthGuard,
    UserService,
    ApiService,
    EnvService,
    SharedDataService
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
