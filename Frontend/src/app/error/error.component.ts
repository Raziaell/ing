import { Component, OnInit } from '@angular/core';

import { Router, ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-error',
  templateUrl: './error.component.html',
  styleUrls: ['./error.component.css']
})
export class ErrorComponent implements OnInit {

  constructor(private router: Router) { }

  ngOnInit() {

    setTimeout((router: Router) => {
      this.router.navigate(['./login']);
  }, 8000); 

  }

}
