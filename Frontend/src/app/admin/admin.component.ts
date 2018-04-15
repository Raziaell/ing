import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';

import { SensorTipology } from '../_modelsIot/sensor.model';
import { IotUserModel, PlantModel, SensorModel, DetectionModel } from '../_modelsIot';
import { SharedDataService, UserService } from '../_services';

@Component({
  selector: 'admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.css']
})
export class AdminComponent implements OnInit {

  constructor(private router: Router, private shared: SharedDataService, private userService: UserService) { }

  logout() {

    this.router.navigate[('./login')];

    this.shared.isAuthenticated = false;

  }

  ngOnInit() {

    this.getAllStandard();
    this.getAllPlants();

  }


  getAllStandard() {

    this.userService.getAllStandard().subscribe(
      data => {
        this.shared.customers = data
      }
    )

  }


  getAllPlants() {


    this.userService.getAllImpianti().subscribe(
      data => {
        this.shared.plantsAdmin = data
      }
    )

  }

}


