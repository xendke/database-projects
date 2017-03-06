function drawroundedarrowbox(ctx,x,y,rad,width,height,text,arrow,colorstroke, colorfill) {
			ctx.lineWidth = 4;
			ctx.strokeStyle = colorstroke;
			ctx.fillStyle = colorfill;
			ctx.font = "bold 16px sans-serif";
			ctx.beginPath();
			ctx.moveTo(x+rad,y);
			ctx.lineTo(x+.5*width-arrow,y);
			ctx.lineTo(x+.5*width,y-arrow);
			ctx.lineTo(x+.5*width+arrow,y);
			ctx.lineTo(x+width-rad,y);
			ctx.arc(x+width-rad,y+rad,rad,-.5*Math.PI,0,false);
			ctx.lineTo(x+width,y+height-rad);
			ctx.arc(x+width-rad,y+height-rad,rad,0,.5*Math.PI,false);
			ctx.lineTo(x+rad,y+height);
			ctx.arc(x+rad,y+height-rad,rad,.5*Math.PI,Math.PI,false);
			ctx.lineTo(x,y+rad);
			ctx.arc(x+rad,y+rad,rad,Math.PI,-.5*Math.PI,false);
			ctx.closePath();
		     ctx.fill();
			ctx.stroke();
			ctx.fillStyle = colorstroke;
			ctx.fillText(text,x+rad,y+rad);
		}
