import { Component, OnInit } from '@angular/core';

import { Router, ActivatedRoute, NavigationEnd } from '@angular/router';

import { SharedDataService, UserService } from '../_services';
import { ILoginModel } from '../_models';
import { IotUserModel, PlantModel, DetectionModel } from '../_modelsIot';

@Component({
  selector: 'standard',
  templateUrl: './standard.component.html',
  styleUrls: ['./standard.component.css']
})
export class StandardComponent implements OnInit {

  userId: number;
  username: string;
  clicked: boolean;
  reload: boolean = false;

  plants: PlantModel[];
  detections: DetectionModel[];

  errorNum: number = 0;
  detNum: number = 0;
  detNumTotal: number = 0;
  avgTemp: number = 0;

  today = new Date();
  datestring: string;

  arrayTemp: number[] = [];
  arrayUmid: number[] = [];
  arrayPrec: number[] = [];
  arrayPres: number[] = [];
  arrayVent: number[] = [];
  arrayInqu: number[] = [];


  constructor(private router: Router, private shared: SharedDataService, private userService: UserService, private activatedRoute: ActivatedRoute) { }

  logout() {

    this.router.navigate[('./login')];
    this.shared.isAuthenticated = false;

  }

  ngOnInit() {

    this.datestring = this.today.getFullYear() + "-" + ("0" + (this.today.getMonth() + 1)).slice(-2) + "-" + ("0" + this.today.getDate()).slice(-2);

    this.username = this.shared.user.Username;
    this.errorNum = 0;

    this.getId(this.shared.user);

  }

  //metodi che usano api server

  public getId(user: ILoginModel) {

    this.userService.getId(user).subscribe(
      data => {

        var json = '{"ClienteId":' + data[0].Id + '}';
        var obj = JSON.parse(json);

        this.shared.clienteId = obj;

        this.getImpianti(obj)
      }
    )
  }

  public getImpianti(user: any) {

    this.userService.getImpianti(user).subscribe(
      data => {

        this.plants = data[0];
        this.shared.plants = this.plants;

      }
    )
  }

  public getDetections(plantId: string) {

    this.clicked = true;
    var json = '{"Id":' + plantId + '}';
    var obj = JSON.parse(json);

    this.userService.getDetections(obj).subscribe(
      data => {

        this.detections = data;
        this.shared.detections = this.detections;

        this.errorNum = 0;
        this.populateStat(this.detections);

      }
    )

  }

  public populateStat(det: DetectionModel[]) {

    let sumTemp: number = 0;
    let numTemp: number = 0;

    let jTemp: number = 0;
    let jUmid: number = 0;
    let jPrec: number = 0;
    let jPres: number = 0;
    let jVent: number = 0;
    let jInqu: number = 0;
    
    this.arrayTemp = [];
    this.arrayUmid = [];
    this.arrayPrec = [];
    this.arrayPres = [];
    this.arrayVent = [];
    this.arrayInqu = [];

    this.detNumTotal = det.length;
    this.detNum = 0;

    for (let i = 0; i < det.length; i++) {

      if (det[i].Errore == 'ERROR FOUND') {
        this.errorNum++;
      }

      if (det[i].Data == this.datestring) {
        this.detNum++;
      }

      if (det[i].Tipo == 'Temperatura') {

        var x = +det[i].Valore
        sumTemp = sumTemp + x;
        numTemp++;

        this.arrayTemp[jTemp] = +det[i].Valore;
        jTemp++;

      }

      if (det[i].Tipo == 'Umidità') {
        this.arrayUmid[jUmid] = +det[i].Valore;
        jUmid++;
      }

      if (det[i].Tipo == 'Precipitazioni') {
        this.arrayPrec[jPrec] = +det[i].Valore;
        jPrec++;
      }

      if (det[i].Tipo == 'Pressione') {
        this.arrayPres[jPres] = +det[i].Valore;
        jPres++;
      }

      if (det[i].Tipo == 'Vento') {
        this.arrayVent[jVent] = +det[i].Valore;
        jVent++;
      }

      if (det[i].Tipo == 'Inquinamento') {
        this.arrayInqu[jInqu] = +det[i].Valore;
        jInqu++;
      }

    }
    
    this.shared.arrayTemp = this.arrayTemp;
    this.shared.arrayUmid = this.arrayUmid;
    this.shared.arrayPrec = this.arrayPrec;
    this.shared.arrayPres = this.arrayPres;
    this.shared.arrayVent = this.arrayVent;
    this.shared.arrayInqu = this.arrayInqu;

    this.avgTemp = Math.round((sumTemp / numTemp) * 100) / 100;

    if (this.router.url == '/dashboard') {
      this.router.navigate(['./stats'], { relativeTo: this.activatedRoute });
    }
    if (this.router.url == '/dashboard/stats') {
      this.router.navigate(['./stats2'], { relativeTo: this.activatedRoute });
    }
    if (this.router.url == '/dashboard/stats2') {
      this.router.navigate(['./stats'], { relativeTo: this.activatedRoute });
    }

  }

}

